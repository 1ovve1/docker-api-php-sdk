<?php declare(strict_types=1);

namespace Lowel\Docker\Exceptions\Response;

use Lowel\Docker\Exceptions\DockerClientException;

class ResponseJsonContentTypeException extends DockerClientException
{
    const MESSAGE = "Could not parse response as json because Content-Type header is not set as application/json";

    public function __construct()
    {
        parent::__construct(self::MESSAGE);
    }


}