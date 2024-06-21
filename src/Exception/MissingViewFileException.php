<?php

/*
 * Copyright (c) 2024 Daniela Kleemann
 * SPDX-License-Identifier: MIT
 */

declare(strict_types=1);

namespace SweetBlog\Exception;

/**
 * Exception thrown by the View class if the requested view file does not exist.
 */
final class MissingViewFileException extends \Exception
{
    public function __construct(string $message, int $code = 0, \Throwable $previous = null)
    {
        parent::__construct("Missing view file: {$message}", $code, $previous);
    }
}
