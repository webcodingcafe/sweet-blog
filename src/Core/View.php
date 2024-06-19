<?php

/*
 * Copyright (c) 2024 Daniela Kleemann
 * SPDX-License-Identifier: MIT
 */

declare(strict_types=1);

namespace SweetBlog\Core;

/**
 * Class used to load view files.
 */
final readonly class View
{
    /**
     * View constructor.
     *
     * @param string $viewsDirectory Absolute views directory path
     */
    public function __construct(private string $viewsDirectory)
    {
        if (!is_dir($this->viewsDirectory)) {
            throw new \InvalidArgumentException('Invalid views directory path.');
        }
    }

    /**
     * Loads the specified view file from the views directory.
     *
     * @param string $viewFileName File name of the view file
     * @return void
     */
    public function render(string $viewFileName): void
    {
        // TODO: Validate parameter $viewFilename

        $viewFile = $this->viewsDirectory . \DIRECTORY_SEPARATOR . $viewFileName . '.php';

        if (file_exists($viewFile)) {
            require $viewFile;
        }

        // TODO: Throw an exception
    }
}
