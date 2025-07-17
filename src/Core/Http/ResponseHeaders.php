<?php

declare(strict_types=1);

namespace SweetBlog\Core\Http;

/**
 * HTTP response headers.
 */
final class ResponseHeaders
{
    /**
     * @var array<string, string> Header field collection
     */
    private(set) array $headerFields = [];

    /**
     * Adds a new header field to the collection.
     */
    public function add(string $fieldName, string $fieldValue): void
    {
        $this->headerFields[$fieldName] = $fieldValue;
    }

    /**
     * Sends all HTTP response header fields to the client.
     */
    public function send(): void
    {
        foreach ($this->headerFields as $fieldName => $fieldValue) {
            header(sprintf('%s: %s', $fieldName, $fieldValue));
        }
    }
}
