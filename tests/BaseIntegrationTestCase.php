<?php

declare(strict_types=1);

namespace Tests;

use GuzzleHttp\Client;
use Override;
use PHPUnit\Framework\TestCase;
use Random\RandomException;
use RuntimeException;
use Symfony\Component\Process\Process;

/**
 * Base test case for integration tests that require a web server.
 */
abstract class BaseIntegrationTestCase extends TestCase
{
    /**
     * @var \GuzzleHttp\Client Instance of Guzzle's HTTP client
     */
    protected static Client $client;

    /**
     * @var \Symfony\Component\Process\Process Process of the built-in web server
     */
    protected static Process $process;

    #[Override]
    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        $host = '127.0.0.1:' . self::getRandomPort();

        self::$client = new Client([
            'base_uri' => "http://{$host}",
        ]);

        self::$process = new Process([
            'php',
            '--server',
            $host,
            '--docroot',
            self::getDocumentRoot(),
        ]);

        self::$process->disableOutput();

        self::$process->start();

        sleep(seconds: 1); // Wait 1 second to allow the web server to start
    }

    /**
     * @return int Random port number between 8000 and 8999
     */
    private static function getRandomPort(): int
    {
        try {
            $port = random_int(
                min: 8000,
                max: 8999,
            );
        } catch (RandomException $e) {
            throw new RuntimeException(sprintf('Failed to get random port number: %s', $e->getMessage()));
        }

        return $port;
    }

    /**
     * @return string Absolute path to document root directory
     */
    private static function getDocumentRoot(): string
    {
        return dirname(__DIR__) . DIRECTORY_SEPARATOR . 'public';
    }

    #[Override]
    public static function tearDownAfterClass(): void
    {
        self::$process->stop();

        parent::tearDownAfterClass();
    }
}
