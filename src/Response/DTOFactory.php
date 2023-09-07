<?php declare(strict_types=1);

namespace Lowel\Docker\Response;

use Lowel\Docker\Response\DTO\Container;
use Lowel\Docker\Response\DTO\ContainerListItem;
use Psr\Http\Message\ResponseInterface;

class DTOFactory
{
    /** @var ResponseParserInterface  */
    protected ResponseParserInterface $responseParser;

    /**
     * @param ResponseParserInterface $responseParser
     */
    public function __construct(ResponseParserInterface $responseParser)
    {
        $this->responseParser = $responseParser;
    }

    /**
     * @param ResponseInterface $response
     * @return array<ContainerListItem>
     */
    function createDockerCollectionFromResponse(ResponseInterface $response): array
    {
        $collection = [];
        $arrayData = $this->responseParser->parseBodyAsJson($response);

        foreach ($arrayData as $containerInfo) {
            $collection[] = new ContainerListItem($containerInfo);
        }

        return $collection;
    }

    /**
     * @param ResponseInterface $response
     * @return Container
     */
    function createContainerFromResponse(ResponseInterface $response): Container
    {
        $arrayData = $this->responseParser->parseBodyAsJson($response);

        return new Container($arrayData);
    }
}