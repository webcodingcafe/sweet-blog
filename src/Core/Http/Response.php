<?php

declare(strict_types=1);

namespace SweetBlog\Core\Http;

/**
 * HTTP response.
 */
final readonly class Response
{
    public function __construct(
        private ResponseBody $body = new ResponseBody(),
        private ResponseHeaders $headers = new ResponseHeaders(),
        private StatusCode $statusCode = StatusCode::Ok,
    ) {}

    /**
     * Sends the HTTP response to the client.
     */
    public function send(): void
    {
        http_response_code($this->statusCode->value);
        $this->headers->send();
        echo $this->body->content;
    }
}
