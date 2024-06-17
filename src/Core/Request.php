<?php

/*
 * Copyright (c) 2024 Daniela Kleemann
 * SPDX-License-Identifier: MIT
 */

declare(strict_types=1);

namespace SweetBlog\Core;

/**
 * Class used to get information about the current request.
 */
final class Request
{
    /**
     * Returns the request method of the current request.
     *
     * @return string Request method
     */
    public function method(): string
    {
        if (!isset($_SERVER['REQUEST_METHOD'])) {
            throw new \RuntimeException('Request method not set.');
        }

        if (!is_string($_SERVER['REQUEST_METHOD'])) {
            throw new \RuntimeException('Request method must be a string.');
        }

        return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * Returns the request URI of the current request.
     *
     * @return string Request URI
     */
    public function uri(): string
    {
        if (!isset($_SERVER['REQUEST_URI'])) {
            throw new \RuntimeException('Request URI not set.');
        }

        if (!is_string($_SERVER['REQUEST_URI'])) {
            throw new \RuntimeException('Request URI must be a string.');
        }

        return $_SERVER['REQUEST_URI'];
    }
}
