<?php
namespace Simple\Request\Rest\Header\Collection;

use Simple\Request\Rest\Header\Header;

class Authorization extends Header
{

    private string $value;

    private function __construct($type, $data)
    {
        $this->value = sprintf("%s %s", $type, $data);
    }

    public static final function bearer($value): Authorization
    {
        return new Authorization('Bearer', $value);
    }

    public function getKey(): string
    {
        return 'Authorization';
    }

    public function getValue(): string
    {
        return $this->value;
    }
}