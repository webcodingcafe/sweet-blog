<?php

declare(strict_types=1);

namespace SweetBlog\Core\Http;

/**
 * Handles the HTTP response body content.
 */
final readonly class HttpResponseBody
{
    public function __construct(
        private(set) string $content = '',
    ) {}
}
