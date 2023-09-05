<?php declare(strict_types=1);

namespace Lowel\Docker\Exceptions;

use RuntimeException;
use Throwable;
use function print_r, sprintf;

class DockerClientException extends RuntimeException
{
    const DEFAULT_MESSAGE = "Docker error";

    /**
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(string $message = self::DEFAULT_MESSAGE, int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

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