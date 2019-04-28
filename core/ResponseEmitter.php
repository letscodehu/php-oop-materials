<?php 
class ResponseEmitter {

    public function emit(Response $response) {
        $this->emitStatusLine($response->getStatusCode(), $response->getReasonPhrase());
        $this->emitHeaders($response->getHeaders());
        $this->emitBody($response->getBody());
    }

    private function emitStatusLine(int $statusCode, string $reasonPhrase) {
        header(sprintf(
            'HTTP/1.1 %d%s',
            $statusCode,
            ($reasonPhrase ? ' ' . $reasonPhrase : '')
        ), true, $statusCode);
    }

    private function emitHeaders(array $headers) {
        foreach ($headers as $key => $value) {
            header(sprintf("%s: %s", $key, $value));
        }
    }

    private function emitBody(string $body) {
        echo $body;
    }
}