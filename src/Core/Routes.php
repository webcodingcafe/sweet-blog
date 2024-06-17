<?php

/*
 * Copyright (c) 2024 Daniela Kleemann
 * SPDX-License-Identifier: MIT
 */

declare(strict_types=1);

namespace SweetBlog\Core;

/**
 * Class used to provide an iterable route map.
 */
final class Routes
{
    /**
     * @return \Generator<array{0: string, 1: string, 2: class-string}>
     */
    public function __invoke(): \Generator
    {
        yield ['GET', '/', \SweetBlog\Controllers\HomeController::class];
    }
}
