<?php

namespace Simple\Request\Rest\Body;

abstract class Body
{
    abstract public function getAsString();

    public function getHeaders()
    {
        return null;
    }
}