<?php

declare(strict_types=1);

namespace Tests\Integration;

use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use Random\RandomException;
use RuntimeException;
use Symfony\Component\Process\Process;

abstract class IntegrationTestCase extends TestCase
{
    /**
     * @var \Symfony\Component\Process\Process The built-in web server process.
     */
    protected static Process $process;

    /**
     * @var \GuzzleHttp\Client The HTTP client instance.
     */
    protected static Client $client;

    /**
     * @var string The IP address to use for starting the built-in web server.
     */
    protected static string $host = '127.0.0.1';

    /**
     * @var int A random port to use for starting the built-in web server.
     */
    protected static int $port;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        try {
            self::$port = random_int(8000, 9000);
        } catch (RandomException) {
            throw new RuntimeException('Failed to generate a random port.');
        }

        self::$process = new Process([
            'php',
            '-S',
            sprintf('%s:%d', self::$host, self::$port),
            '-t',
            realpath(__DIR__ . '/../../public'),
        ]);

        self::$process->disableOutput();

        self::$process->start();

        sleep(1);

        if (!self::$process->isRunning()) {
            throw new RuntimeException('Failed to start the built-in web server.');
        }

        self::$client = new Client([
            'base_uri' => sprintf('http://%s:%d', self::$host, self::$port),
        ]);
    }

    public static function tearDownAfterClass(): void
    {
        self::$process->stop(3);

        parent::tearDownAfterClass();
    }
}
