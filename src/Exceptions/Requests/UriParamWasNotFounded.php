<?php declare(strict_types=1);

namespace Lowel\Docker\Exceptions\Requests;

use Lowel\Docker\Exceptions\DockerClientException;

class UriParamWasNotFounded extends DockerClientException
{
    const MESSAGE = "uri param '%s' was not founded in '%s' by given params map:\n%s";

    /**
     * @param string $uri
     * @param string $paramName
     * @param array $paramsMap
     */
    public function __construct(string $uri, string $paramName, array $paramsMap)
    {
        $message = sprintf(
            self::MESSAGE,
            $paramName, $uri, $this->printArray($paramsMap)
        );

        parent::__construct($message);
    }
}