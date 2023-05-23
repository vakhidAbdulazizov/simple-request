<?php
namespace Simple\Request\Rest\Header\Collection;

use Simple\Request\Rest\Header\Header;

class ContentType extends Header
{
    private $value;
    private function __construct($type)
    {
        $this->value = $type;
    }

    public static final function json(): ContentType
    {
        return new ContentType('application/json');
    }

    public static final function plain(): ContentType
    {
        return new ContentType('text/plain');
    }

    public function getKey(): string
    {
        return 'Content-Type';
    }

    public function getValue(): string
    {
        return $this->value;
    }
}