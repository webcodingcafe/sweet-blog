<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Routing;

use Generator;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use SweetBlog\App\Controllers\HomeController;
use SweetBlog\Core\Exceptions\ResourceNotFoundException;
use SweetBlog\Core\Routing\Router;

#[CoversClass(Router::class)]
final class RouterTest extends TestCase
{
    /**
     * @return \Generator<array{0: string, 1: string, 2: array{0: class-string, 1: string}}>
     */
    public static function validRouteProvider(): Generator
    {
        yield 'home page GET' => ['GET', '/', [HomeController::class, 'index']];
        yield 'home page HEAD' => ['HEAD', '/', [HomeController::class, 'index']];
    }

    /**
     * @return \Generator<array{0: string, 1: string}>
     */
    public static function invalidRouteProvider(): Generator
    {
        yield 'non-existent' => ['GET', '/non-existent'];
        yield 'home page POST' => ['POST', '/'];
    }

    /**
     * @param string $method HTTP request method
     * @param string $uri HTTP request URI
     * @param array{0: class-string, 1: string} $expectedController Expected controller
     *
     * @return void
     */
    #[DataProvider('validRouteProvider')]
    public function testValidRoutes(string $method, string $uri, array $expectedController): void
    {
        $_SERVER['REQUEST_METHOD'] = $method;
        $_SERVER['REQUEST_URI'] = $uri;

        try {
            $controller = new Router()->dispatch();
        } catch (ResourceNotFoundException $e) {
            $this->fail($e->getMessage());
        }

        $this->assertSame($expectedController, $controller);
    }

    #[DataProvider('invalidRouteProvider')]
    public function testRouteNotFound(string $method, string $uri): void
    {
        $_SERVER['REQUEST_METHOD'] = $method;
        $_SERVER['REQUEST_URI'] = $uri;

        $this->expectException(ResourceNotFoundException::class);
        $this->expectExceptionMessage('Route not found');

        new Router()->dispatch();
    }
}
