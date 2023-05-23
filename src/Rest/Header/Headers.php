<?php
namespace Simple\Request\Rest\Header;


class Headers
{
    private array $chain;

    public function __construct(Header ...$headers)
    {
        $this->chain = $headers;
    }

    public function addHeader(Header $header): static
    {
        $this->chain[] = $header;
        return $this;
    }

    public function asArray(): array
    {
        $result = [];
        foreach($this->chain as $header)
        {
            $result[$header->getKey()] = $header->getValue();
        }

        return $result;
    }
}