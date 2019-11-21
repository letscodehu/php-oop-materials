<?php

use Session\Session;

class Request {

    private $body;
    private $headers;
    private $cookies;
    private $params;
    private $uri;
    private $method;
    private $session;

    public function __construct($uri, $method, Session $session, $body = null, $headers = [], $cookies = [], $params = []) {
        $this->uri = $uri;
        $this->method = $method;
        $this->body = $body;
        $this->headers = $headers;
        $this->cookies = $cookies;
        $this->params = $params;
        $this->session = $session;
    }

    public function getUri() {
        return $this->uri;
    }

    public function getBody() {
        return $this->body;
    }

    public function getHeaders() {
        return $this->headers;
    }

    public function getCookies() {
        return $this->cookies;
    }

    public function getParams() {
        return $this->params;
    }

    public function getMethod() {
        return $this->method;
    }

    public function getSession()
    {
        return $this->session;
    }

}