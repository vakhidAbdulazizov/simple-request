<?php
namespace Simple\Request\Rest\Transport\Getaway;

use Simple\Request\Rest\Transport\Request;

class Curl
{
    private $request;
    private $curl;
    private $opt = [];

    const DEBUG = true;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }


    private function debug($header, $body = null)
    {
        if(Curl::DEBUG) $this->opt[$header] = $body;
    }

    private function insertTransferBody()
    {
        if($combined = $this->request->getHttpBody())
        {
            if($body = $combined->getFirstFormattedBody())
            {
                $this->setopt($this->curl, CURLOPT_POSTFIELDS, $body->getAsString());
            }
        }
    }

    private function getCompleteUrl()
    {
        if($combined = $this->request->getHttpBody())
        {
            if($body = $combined->getFirstUrlEncodedBody())
            {
                return sprintf("%s?%s", $this->request->getHttpUrl(), $body->getAsString());
            }
        }

        return $this->request->getHttpUrl();
    }

    private function getCompeteHeaders()
    {
        $headers = [];

        foreach($this->request->getHttpHeaders() as $key => $value)
        {
            $headers[] = sprintf("%s: %s", $key, $value);
        }

        return $headers;
    }

    private function send()
    {
        $this->curl = curl_init();

        switch($this->request->getHttpMethod())
        {
            case Request::POST:
                $this->setopt($this->curl, CURLOPT_POST, 1);
                break;
            default:
                $this->setopt($this->curl, CURLOPT_CUSTOMREQUEST, $this->request->getHttpMethod());
                break;
        }

        $this->setopt($this->curl, CURLOPT_URL, $this->getCompleteUrl());
        $this->setopt($this->curl, CURLOPT_HTTPHEADER, $this->getCompeteHeaders());
        $this->setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);

        if(($user = $this->request->getUser())  && ($password = $this->request->getPassword()))
        {
            $this->setopt($this->curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            $this->setopt($this->curl, CURLOPT_USERPWD, $user . ':' . $password);
        }

        $this->insertTransferBody();
        $result = curl_exec($this->curl);

        $httpcode = curl_getinfo($this->curl, CURLINFO_HTTP_CODE);
        curl_close($this->curl);


        return [$httpcode ?: 0, $result];

    }

    private function setopt($conn, $key, $value)
    {
        $all = get_defined_constants();
        foreach($all as $code => $val)
        {
            if($val === $key)
            {
                $this->debug($code, $value);
                break;
            }
        }
        curl_setopt($conn, $key, $value);
    }

    public static function query(Request $request)
    {
        return (new Curl($request))->send();
    }
}