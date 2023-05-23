<?php

namespace Simple\Request\Rest\Body;

use Simple\Request\Rest\Header\Headers;

class Combined extends Stream
{

    private $bodies;

    private function __construct(Body ...$bodies)
    {
        $this->bodies = $bodies;
    }

    public function streamAsString(): \Generator
    {
        foreach ($this->bodies as $body) {
            yield $body->getAsString();
        }
    }


    public function getFirstUrlEncodedBody(): UrlBody|null
    {

        foreach ($this->bodies as $body) {
            if ($body instanceof UrlBody) {
                return $body;
            }
        }

        return null;
    }


    public function getFirstFormattedBody(): ?Body
    {

        foreach ($this->bodies as $body) {
            if (!$body instanceof UrlBody) {
                return $body;
            }
        }

        return null;
    }

    public function getHeaders(): array
    {
        $result = [];
        /** @var Body $body */
        foreach ($this->bodies as $body) {
            if ($headers = $body->getHeaders()) {
                if ($headers instanceof Headers) {
                    $result[] = $headers->asArray();
                } else if (is_array($headers)) {
                    $result[] = $headers;
                }
            }
        }

        return array_merge(...$result);
    }

    public static function combine(Body ...$bodies): Combined
    {
        return new Combined(...$bodies);
    }
}