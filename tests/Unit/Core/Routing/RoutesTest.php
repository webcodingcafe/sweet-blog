<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Routing;

use Override;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use SweetBlog\Core\Routing\Routes;

#[CoversClass(Routes::class)]
final class RoutesTest extends TestCase
{
    private static mixed $routeMapFixture;

    #[Override]
    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        self::$routeMapFixture = require dirname(__DIR__, 3) . '/Fixtures/routeMap.php';
    }

    public function testCheckRouteMap(): void
    {
        $routes = new Routes();

        $this->assertSame(self::$routeMapFixture, $routes->map);
    }
}
