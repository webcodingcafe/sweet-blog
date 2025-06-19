<?php

declare(strict_types=1);

namespace SweetBlog\Core\Http;

/**
 * The HTTP request lifecycle.
 */
final readonly class HttpKernel
{
    /**
     * Handles the HTTP request and returns the HTTP response.
     *
     * @return \SweetBlog\Core\Http\HttpResponse
     */
    public function handle(): HttpResponse
    {
        $httpResponseBody = new HttpResponseBody('Hello, world!');

        return new HttpResponse($httpResponseBody);
    }
}
