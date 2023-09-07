<?php declare(strict_types=1);

namespace Lowel\Docker\Async;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Promise\PromiseInterface;
use Lowel\Docker\Requests\RequestFactoryInterface;
use Lowel\Docker\Requests\RequestTypeEnum;

class AsyncClient implements AsyncClientInterface
{
    /** @var GuzzleClient */
    protected GuzzleClient $asyncHttpClient;
    /** @var RequestFactoryInterface  */
    protected RequestFactoryInterface $requestFactory;

    public function __construct(GuzzleClient $asyncHttpClient, RequestFactoryInterface $requestFactory)
    {
        $this->asyncHttpClient = $asyncHttpClient;
        $this->requestFactory = $requestFactory;
    }

    /**
     * @inheritDoc
     */
    function containerList(bool $all = false, ?int $limit = null, bool $size = false, ?string $filters = null): PromiseInterface
    {
        $request = $this->requestFactory->get(
            RequestTypeEnum::CONTAINER_LIST,
            [],
            compact('all', 'limit', 'size', 'filters')
        );

        return $this->asyncHttpClient->sendAsync($request);
    }

    /**
     * @inheritDoc
     */
    function containerInspect(string $id, bool $size = false): PromiseInterface
    {
        $request = $this->requestFactory->get(
            RequestTypeEnum::CONTAINER_INSPECT,
            ['id' => $id],
            compact('size')
        );

        return $this->asyncHttpClient->sendAsync($request);
    }

    /**
     * @inheritDoc
     */
    function containerStart(string $id, ?string $detachKeys = null): PromiseInterface
    {
        $request = $this->requestFactory->post(
            RequestTypeEnum::CONTAINER_START,
            ['id' => $id],
            compact('detachKeys')
        );

        return $this->asyncHttpClient->sendAsync($request);
    }

    /**
     * @inheritDoc
     */
    function containerStop(string $id, ?string $signal = null, ?int $t = null): PromiseInterface
    {
        $request = $this->requestFactory->post(
            RequestTypeEnum::CONTAINER_STOP,
            ['id' => $id],
            compact('signal', 't')
        );

        return $this->asyncHttpClient->sendAsync($request);
    }

    /**
     * @inheritDoc
     */
    function containerRestart(string $id, ?string $signal = null, ?int $t = null): PromiseInterface
    {
        $request = $this->requestFactory->post(
            RequestTypeEnum::CONTAINER_RESTART,
            ['id' => $id],
            compact('signal', 't')
        );

        return $this->asyncHttpClient->sendAsync($request);
    }


}