<?php
namespace Simple\Request\Rest\Header;

abstract class Header
{
    /**
     * @return string
     */
    abstract public function getKey(): string;

    /**
     * @return string
     */
    abstract public function getValue(): string;
}