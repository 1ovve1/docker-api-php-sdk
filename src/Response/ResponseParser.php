<?php declare(strict_types=1);

namespace Lowel\Docker\Response;

use Lowel\Docker\Exceptions\Response\ResponseJsonContentTypeException;
use Lowel\Docker\Exceptions\Response\ResponseJsonParsingException;
use Psr\Http\Message\ResponseInterface;

class ResponseParser implements ResponseParserInterface
{
    /**
     * @inheritDoc
     */
    function parseBodyAsJson(ResponseInterface $response): array
    {
        if (!$response->hasHeader('Content-Type') || !$response->getHeader('Content-Type') === ['application/json']) {
            throw new ResponseJsonContentTypeException();
        }

        $rawData = $response->getBody()->getContents();

        $encoded = json_decode($rawData, true);

        if ($encoded === null) {
            throw new ResponseJsonParsingException($rawData);
        }

        return $encoded;
    }
}