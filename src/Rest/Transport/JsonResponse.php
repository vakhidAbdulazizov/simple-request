<?php
namespace Simple\Request\Rest\Transport;

class JsonResponse extends Response
{
    public function __construct(Request $request, $http_code, $raw)
    {
        parent::__construct($request, $http_code, $raw);
    }

    public function getFormattedData()
    {
        return json_decode($this->getRawData(), true);
    }
}