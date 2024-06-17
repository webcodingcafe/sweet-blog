<?php

/*
 * Copyright (c) 2024 Daniela Kleemann
 * SPDX-License-Identifier: MIT
 */

declare(strict_types=1);

namespace SweetBlog\Exception;

/**
 * Exception thrown if a requested resource does not exist.
 */
final class HttpNotFoundException extends \Exception {}
