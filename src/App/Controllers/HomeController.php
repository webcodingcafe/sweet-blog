<?php

declare(strict_types=1);

namespace SweetBlog\App\Controllers;

use SweetBlog\Core\Http\HttpResponse;
use SweetBlog\Core\Http\HttpResponseBody;

/**
 * Responsible for the home page.
 */
final readonly class HomeController
{
    /**
     * Builds the home page content and returns it in the HTTP response.
     *
     * @return \SweetBlog\Core\Http\HttpResponse
     */
    public function index(): HttpResponse
    {
        $content = 'Hello, world!';
        $httpResponseBody = new HttpResponseBody($content);

        return new HttpResponse($httpResponseBody);
    }
}
