<?php declare(strict_types=1);

namespace Lowel\Docker\Exceptions\Response;

use Lowel\Docker\Exceptions\DockerClientException;

class ResponseJsonParsingException extends DockerClientException
{
    const MESSAGE = "Cannot parse response body as Json, raw data:\n%s";

    public function __construct(string $rawData)
    {
        $message = $this->format(self::MESSAGE, $rawData);

        parent::__construct($message);
    }


}