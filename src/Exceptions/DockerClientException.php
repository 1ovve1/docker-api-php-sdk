<?php declare(strict_types=1);

namespace Lowel\Docker\Exceptions;

use RuntimeException;
use function print_r, sprintf;

class DockerClientException extends RuntimeException
{
    /**
     * Convert given array into string
     *
     * @param mixed $value
     * @return string
     */
    function printAsString(mixed $value): string
    {
        return print_r($value, true);
    }

    /**
     * Formatted print
     *
     * @param string $message
     * @param string ...$params
     * @return string
     */
    function format(string $message, string ...$params): string
    {
        return sprintf($message, ...$params);
    }
}