<?php declare(strict_types=1);

namespace Lowel\Docker\Exceptions;

use Psr\Http\Message\ResponseInterface;

class DockerClientInvalidParamsException extends DockerClientException
{
    const MESSAGE = "Invalid params in docker api call, message:\n%s\nArguments given:\n%s";

    /**
     * @param array<mixed> $params
     */
    public function __construct(array $params, ResponseInterface $response)
    {
        $message = json_decode($response->getBody()->getContents());

        $message = $this->format(self::MESSAGE, $this->printAsString($message), $this->printAsString($params));

        parent::__construct($message);
    }
}