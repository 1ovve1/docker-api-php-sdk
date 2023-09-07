<?php declare(strict_types=1);

namespace Lowel\Docker\Response;

use Lowel\Docker\Exceptions\Response\ResponseJsonContentTypeException;
use Lowel\Docker\Exceptions\Response\ResponseJsonParsingException;
use Psr\Http\Message\ResponseInterface;

interface ResponseParserInterface
{
    /**
     * Parse response body as json
     *
     * @param ResponseInterface $response
     * @return array
     * @throws ResponseJsonContentTypeException
     * @throws ResponseJsonParsingException
     */
    function parseBodyAsJson(ResponseInterface $response): array;
}