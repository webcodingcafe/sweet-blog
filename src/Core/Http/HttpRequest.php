<?php

declare(strict_types=1);

namespace SweetBlog\Core\Http;

use RuntimeException;

/**
 * Handles HTTP Request information.
 */
final readonly class HttpRequest
{
    private(set) string $method;
    private(set) string $uri;

    /**
     * Sets the request method and request URI.
     */
    public function __construct()
    {
        $this->method = $this->requestMethodFromSuperglobal();
        $this->uri = $this->requestUriFromSuperglobal();
    }

    /**
     * @return string Request method from _SERVER superglobal
     */
    private function requestMethodFromSuperglobal(): string
    {
        if (!isset($_SERVER['REQUEST_METHOD'])) {
            throw new RuntimeException('REQUEST_METHOD not set');
        }

        if (!is_string($_SERVER['REQUEST_METHOD'])) {
            throw new RuntimeException('REQUEST_METHOD must be of type string');
        }

        if (HttpMethod::tryFrom($_SERVER['REQUEST_METHOD']) === null) {
            throw new RuntimeException('Request method not supported: ' . $_SERVER['REQUEST_METHOD']);
        }

        return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * @return string Request URI from _SERVER superglobal
     */
    private function requestUriFromSuperglobal(): string
    {
        if (!isset($_SERVER['REQUEST_URI'])) {
            throw new RuntimeException('REQUEST_URI not set');
        }

        if (!is_string($_SERVER['REQUEST_URI'])) {
            throw new RuntimeException('REQUEST_URI must be of type string');
        }

        return $_SERVER['REQUEST_URI'];
    }
}
