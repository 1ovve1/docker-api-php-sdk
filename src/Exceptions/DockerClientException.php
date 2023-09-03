<?php declare(strict_types=1);

namespace Lowel\Docker\Exceptions;

use RuntimeException;
use function print_r;

class DockerClientException extends RuntimeException
{
    /**
     * Convert given array into string
     *
     * @param array $array
     * @return string
     */
    function printArray(array $array): string
    {
        return print_r($array, true);
    }
}