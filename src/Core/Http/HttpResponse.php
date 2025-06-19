<?php

declare(strict_types=1);

namespace SweetBlog\Core\Http;

/**
 * Handles the HTTP response.
 */
final readonly class HttpResponse
{
    public function __construct(
        private(set) HttpResponseBody $httpResponseBody = new HttpResponseBody(),
        private(set) HttpStatusCode $httpStatusCode = HttpStatusCode::Ok,
    ) {}

    /**
     * Sends the HTTP response to the client.
     *
     * @return void
     */
    public function send(): void
    {
        http_response_code($this->httpStatusCode->value);

        echo $this->httpResponseBody->content;
    }
}
