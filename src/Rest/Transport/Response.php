<?php
namespace Simple\Request\Rest\Transport;

abstract class Response
{
    private $raw;
    private $http_code;
    private $request;
    protected function __construct(Request $request, $http_code, $raw)
    {
        $this->http_code = $http_code;
        $this->raw = $raw;
        $this->request = $request;
    }

    public function getRawData()
    {
        return $this->raw; 
    }

    public function getStatusCode()
    {
        return $this->http_code;
    }

    public function getRequest()
    {
        return $this->request;
    }

    abstract public function getFormattedData();
}