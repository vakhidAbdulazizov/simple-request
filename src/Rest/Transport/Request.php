<?php
namespace Simple\Request\Rest\Transport;

use Simple\Request\Rest\Body\Combined;
use Simple\Request\Rest\Header\Headers;
use Simple\Request\Rest\Method\Method;
use Simple\Request\Rest\Body\Body;
use Simple\Request\Rest\Transport\Getaway\Curl;

class Request
{
    const GET = 'GET';
    const POST = 'POST';
    const PUT = 'PUT';
    const DELETE = 'DELETE';

    protected $method;

    protected $user;
    protected $password;

    protected $http_method;
    protected $http_headers;
    /** @var Combined $http_body */
    protected $http_body = null;
    protected $http_url;

    protected $gateway = Curl::class;

    protected function __construct(Method $method)
    {
        $this->method = $method;
    }

    public function getHttpMethod()
    {
        return $this->http_method;
    }

    public function getHttpUrl()
    {
        return $this->http_url;
    }

    public function getHttpHeaders()
    {
        return $this->http_headers;
    }


    public function getHttpBody()
    {
        return $this->http_body;
    }

    public static function bind(Method $method)
    {
        $request = new static($method);

        $request->http_method = $method->getHttpMethod();
        $request->http_url = $method->getHttpUrl();

        $headers = $method->getHttpHeaders();
        if($headers instanceof Headers)
            $headers = $headers->asArray();
        $request->http_headers = $headers;

        if($body = $method->getHttpBody())
        {
            if($body instanceof Body)
            {
                $body = Combined::combine($body);
            }
            $request->http_body = $body;
            if($headers = $body->getHeaders())
            {
                if($headers instanceof Headers)
                    $headers = $headers->asArray();
                $request->http_headers = array_merge($headers, $request->http_headers);
            }
        }

        $method->runExtra($request);

        return $request;
    }


    public function send()
    {
        /** @var Curl $gateway */
        $gateway = $this->gateway;

        list($http_status, $raw_body) = $gateway::query($this);

        return $this->method->getResponseInstance($this, $http_status, $raw_body);
    }

    /**
     * @return mixed
     */
    public function getPassword(): mixed
    {
        return $this->password;
    }

    /**
     * @return mixed
     */
    public function getUser(): mixed
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user): static
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password): static
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return Method
     */
    public function getMethodClass(): Method
    {
        return $this->method;
    }
}