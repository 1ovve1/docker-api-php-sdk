<?php declare(strict_types=1);

namespace Lowel\Docker;

use JsonException;
use Lowel\Docker\Requests\RequestFactoryInterface;
use Lowel\Docker\Requests\RequestFactoryJson;
use Lowel\Docker\Requests\RequestTypeEnum;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface as HttpClientInterface;
use Psr\Http\Message\ResponseInterface;

class Client implements ClientInterface
{
    /** @var HttpClientInterface  */
    protected HttpClientInterface $httpClient;
    /** @var RequestFactoryInterface  */
    protected RequestFactoryInterface $requestFactory;


    /**
     * @param HttpClientInterface $httpClient - PSR Http client instance
     */
    public function __construct(HttpClientInterface $httpClient, RequestFactoryInterface $requestFactory)
    {
        $this->httpClient = $httpClient;

        $this->requestFactory = $requestFactory;
    }

    /**
     * @inheritDoc
     * @param bool $all
     * @param int|null $limit
     * @param bool $size
     * @param string|null $filters
     * @return ResponseInterface
     * @throws JsonException
     * @throws ClientExceptionInterface
     */
    function containerList(bool $all = false, ?int $limit = null, bool $size = false, ?string $filters = null): ResponseInterface
    {
        $request = $this->requestFactory->get(
            RequestTypeEnum::CONTAINER_LIST,
            [],
            compact('all', 'limit', 'size', 'filters')
        );

        return $this->httpClient->sendRequest($request);
    }

    /**
     * @inheritDoc
     */
    function containerInspect(string $id, bool $size = false): ResponseInterface
    {
        $request = $this->requestFactory->get(
            RequestTypeEnum::CONTAINER_INSPECT,
            ['id' => $id],
            compact('size')
        );

        return $this->httpClient->sendRequest($request);
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