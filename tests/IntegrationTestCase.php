<?php

declare(strict_types=1);

namespace Tests;

use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use Random\RandomException;
use RuntimeException;
use Symfony\Component\Process\Process;

abstract class IntegrationTestCase extends TestCase
{
    /**
     * The hostname or IP address of the web server.
     */
    private const string HOST = '127.0.0.1';

    /**
     * @var \GuzzleHttp\Client The HTTP client used to send requests to the web server.
     */
    protected static Client $client;

    /**
     * @var int The port number of the web server.
     */
    private static int $port;

    /**
     * @var string The absolute path to the document root directory.
     */
    private static string $documentRoot;

    /**
     * @var string The base URI used by Guzzle's HTTP client.
     */
    private static string $baseUri;

    /**
     * @var \Symfony\Component\Process\Process The process used to run the built-in web server.
     */
    private static Process $process;

    /**
     * Starts the built-in web server and sets up the HTTP client.
     *
     * @return void
     */
    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        self::$port = self::getRandomPort();
        self::$documentRoot = self::getDocumentRoot();
        self::$baseUri = sprintf('http://%s:%d', self::HOST, self::$port);

        self::$client = new Client([
            'base_uri' => self::$baseUri,
        ]);

        self::$process = new Process([
            'php',
            '-S',
            sprintf('%s:%d', self::HOST, self::$port),
            '-t',
            self::$documentRoot,
        ]);

        self::$process->disableOutput();
        self::$process->start();

        sleep(1);
    }

    /**
     * Stops the built-in web server.
     *
     * @return void
     */
    public static function tearDownAfterClass(): void
    {
        self::$process->stop();

        parent::tearDownAfterClass();
    }

    /**
     * Returns the absolute path to the document root directory.
     *
     * @return string Absolute path to the document root directory.
     */
    private static function getDocumentRoot(): string
    {
        $documentRoot = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'public';

        if (!is_dir($documentRoot)) {
            throw new RuntimeException(sprintf('Failed to resolve the document root: %s', $documentRoot));
        }

        return $documentRoot;
    }

    /**
     * Returns a random port number between 8000 and 9000.
     *
     * @return int Port number.
     *
     */
    private static function getRandomPort(): int
    {
        try {
            $port = random_int(8000, 9000);
        } catch (RandomException $e) {
            throw new RuntimeException(sprintf('Failed to generate a random port number: %s', $e->getMessage()));
        }

        return $port;
    }
}
