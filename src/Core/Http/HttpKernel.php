<?php

declare(strict_types=1);

namespace SweetBlog\Core\Http;

use LogicException;
use SweetBlog\Core\Exceptions\ResourceNotFoundException;
use SweetBlog\Core\Routing\Router;

/**
 * The HTTP request lifecycle.
 */
final readonly class HttpKernel
{
    /**
     * Handles the HTTP request and returns the HTTP response.
     *
     * @return \SweetBlog\Core\Http\HttpResponse
     */
    public function handle(): HttpResponse
    {
        try {
            [$controllerClass, $action] = new Router()->dispatch();

            if (!class_exists($controllerClass)) {
                throw new LogicException(sprintf('Controller class does not exist: %s', $controllerClass));
            }

            $controllerCallable = [new $controllerClass(), $action];

            if (!is_callable($controllerCallable)) {
                throw new LogicException(sprintf('Controller is not callable: %s::%s', $controllerClass, $action));
            }

            $httpResponse = call_user_func($controllerCallable);

            if (!($httpResponse instanceof HttpResponse)) {
                throw new LogicException(sprintf(
                    'Controller does not return HttpResponse: %s::%s',
                    $controllerClass,
                    $action,
                ));
            }

            return $httpResponse;
        } catch (ResourceNotFoundException $e) {
            $httpResponseBody = new HttpResponseBody('404 not Found');

            return new HttpResponse($httpResponseBody, HttpStatusCode::NotFound);
        }
    }
}
