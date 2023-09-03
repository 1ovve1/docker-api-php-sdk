<?php declare(strict_types=1);

namespace Lowel\Docker;

use Lowel\Docker\Requests\RequestFactoryInterface;
use Lowel\Docker\Requests\RequestFactoryJson;
use Lowel\Docker\Requests\RequestTypeEnum;
use Lowel\Docker\Response\DTO\Container;
use Lowel\Docker\Response\DTOFactory;
use Lowel\Docker\Response\ResponseParser;
use Psr\Http\Client\ClientInterface as HttpClientInterface;
use Psr\Http\Message\ResponseInterface;

class Client implements ClientInterface
{
    /** @var HttpClientInterface  */
    protected HttpClientInterface $httpClient;
    /** @var RequestFactoryInterface  */
    protected RequestFactoryInterface $requestFactory;
    /** @var DTOFactory  */
    protected DTOFactory $dtoFactory;

    /**
     * @param HttpClientInterface $httpClient - PSR Http client instance
     */
    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;

        $this->requestFactory = new RequestFactoryJson();
        $this->dtoFactory = new DTOFactory(new ResponseParser());
    }

    /**
     * @inheritDoc
     */
    function containerList(bool $all = false, ?int $limit = null, bool $size = false, ?string $filters = null): array
    {
        $request = $this->requestFactory->get(
            RequestTypeEnum::CONTAINER_LIST,
            [],
            compact('all', 'limit', 'size', 'filters')
        );

        $response = $this->httpClient->sendRequest($request);

        return $this->dtoFactory->createDockerCollectionFromResponse($response);
    }

    /**
     * @inheritDoc
     */
    function containerInspect(string $id, bool $size = false): Container
    {
        $request = $this->requestFactory->get(
            RequestTypeEnum::CONTAINER_INSPECT,
            ['id' => $id],
            compact('size')
        );

        $response = $this->httpClient->sendRequest($request);

        return $this->dtoFactory->createContainerFromResponse($response);
    }

    /**
     * @inheritDoc
     */
    function containerStart(string $id, ?string $detachKeys = null): ResponseInterface
    {
        $request = $this->requestFactory->post(
            RequestTypeEnum::CONTAINER_START,
            ['id' => $id],
            compact('detachKeys')
        );

        return $this->httpClient->sendRequest($request);
    }

    /**
     * @inheritDoc
     */
    function containerStop(string $id, ?string $signal = null, ?int $t = null): ResponseInterface
    {
        $request = $this->requestFactory->post(
            RequestTypeEnum::CONTAINER_STOP,
            ['id' => $id],
            compact('signal', 't')
        );

        return $this->httpClient->sendRequest($request);
    }

    /**
     * @inheritDoc
     */
    function containerRestart(string $id, ?string $signal = null, ?int $t = null): ResponseInterface
    {
        $request = $this->requestFactory->post(
            RequestTypeEnum::CONTAINER_RESTART,
            ['id' => $id],
            compact('signal', 't')
        );

        return $this->httpClient->sendRequest($request);
    }
}