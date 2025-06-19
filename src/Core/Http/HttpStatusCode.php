<?php

declare(strict_types=1);

namespace SweetBlog\Core\Http;

/**
 * Represents HTTP status codes as enum cases.
 */
enum HttpStatusCode: int
{
    case Ok = 200;
    case NotFound = 404;
}
