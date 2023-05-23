<?php
namespace Simple\Request\Rest\Method;


use Simple\Request\Rest\Transport\JsonResponse;
use Simple\Request\Rest\Transport\Request;
use Simple\Request\Rest\Transport\Response;

abstract class Method
{

    abstract public function getResponseInstance(Request $request, $http_code, $raw): JsonResponse|Response;

    public function runExtra(Request $request){}

    abstract public function getHttpBody();
    abstract public function getHttpUrl();
    abstract public function getHttpHeaders();
    abstract public function getHttpMethod();
}