<?php

class Response {
        
    private $headers = [];
    private $body;
    private $statusCode;
    private $reasonPhrase;

    public function __construct(string $body, array $headers, int $statusCode, string $reasonPhrase) {
        $this->body = $body;
        $this->headers = $headers;
        $this->statusCode = $statusCode;
        $this->reasonPhrase = $reasonPhrase;
    }

    public function getHeaders() {
        return $this->headers;
    }

    public function getBody() {
        return $this->body;
    }

    public function getStatusCode() {
        return $this->statusCode;
    }
    public function getReasonPhrase() {
        return $this->reasonPhrase;
    }

}