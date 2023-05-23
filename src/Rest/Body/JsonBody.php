<?php

namespace Simple\Request\Rest\Body;

use Simple\Request\Rest\Header\Collection\ContentType;
use Simple\Request\Rest\Header\Headers;

class JsonBody extends Body
{
    private $object;
    public function __construct($object)
    {
        $this->object = $object;
    }

    public function getAsString()
    {
        return json_encode($this->object);
    }

    public function getHeaders()
    {
        return new Headers(ContentType::json());
    }
}