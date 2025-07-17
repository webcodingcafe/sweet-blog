<?php

declare(strict_types=1);

namespace SweetBlog\Core\Http;

/**
 * HTTP kernel.
 */
final class Kernel
{
    public function handle(): Response
    {
        return new Response();
    }
}
