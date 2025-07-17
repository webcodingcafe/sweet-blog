<?php

declare(strict_types=1);

namespace SweetBlog\Core\Http;

/**
 * HTTP response body.
 */
final readonly class ResponseBody
{
    public function __construct(
        private(set) string $content = '',
    ) {}
}
