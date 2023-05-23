<?php

namespace Simple\Request\Rest\Body;

class UrlBody extends Body
{
    private $object;
    public function __construct($object)
    {
        $this->object = $object;
    }

    public function getAsString()
    {
        return http_build_query($this->object);
    }
}