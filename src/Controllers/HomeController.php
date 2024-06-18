<?php

/*
 * Copyright (c) 2024 Daniela Kleemann
 * SPDX-License-Identifier: MIT
 */

declare(strict_types=1);

namespace SweetBlog\Controllers;

/**
 * Class used to provide the home page.
 */
final class HomeController
{
    /**
     * Prints "Hello, world!" on the screen.
     *
     * @return void
     */
    public function __invoke(): void
    {
        echo <<<HTML
            <!doctype html>
            <html lang="en">
            <head>
            <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <link rel="stylesheet" href="assets/css/style.css" >
                <title>Document</title>
            </head>
            <body>
            <p>Hello, world!</p>
            </body>
            </html>
            HTML;
    }
}
