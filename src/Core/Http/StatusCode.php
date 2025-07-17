<?php

declare(strict_types=1);

namespace SweetBlog\Core\Http;

/**
 * HTTP response status codes.
 *
 * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Reference/Status
 */
enum StatusCode: int
{
    case Ok = 200;
    case NotFound = 404;
}
