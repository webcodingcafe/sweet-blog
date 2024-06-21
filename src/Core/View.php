<?php

/*
 * Copyright (c) 2024 Daniela Kleemann
 * SPDX-License-Identifier: MIT
 */

declare(strict_types=1);

namespace SweetBlog\Core;

use SweetBlog\Exception\MissingViewFileException;

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
     *
     * @throws \SweetBlog\Exception\MissingViewFileException
     * @return void
     */
    public function render(string $viewFileName): void
    {
        if (\preg_match('#^[A-Za-z_\-]+$#', $viewFileName) !== 1) {
            throw new \InvalidArgumentException('Invalid view file name.');
        }

        $viewFile = $this->viewsDirectory . \DIRECTORY_SEPARATOR . \basename($viewFileName) . '.php';

        if (!file_exists($viewFile)) {
            throw new MissingViewFileException($viewFileName);
        }

        require $viewFile;
    }
}
