<?php

declare(strict_types=1);

namespace SweetBlog\Core\Http;

/**
 * Represents HTTP request methods as enum cases.
 */
enum HttpMethod: string
{
    case GET = 'GET';
    case HEAD = 'HEAD';
    case POST = 'POST';
}
