<?php declare(strict_types=1);

namespace Lowel\Docker;

use Lowel\Docker\Async\AsyncClient;
use Lowel\Docker\Async\AsyncClientInterface;
use Lowel\Docker\Async\AsyncClientResponseHandler;
use Lowel\Docker\Async\AsyncClientResponseHandlerInterface;
use Lowel\Docker\Requests\RequestFactoryJson;

class ClientFactory
{
    const DEFAULT_DOCKER_API_VERSION = '1.41v';

    /** @var array  */
    protected readonly array $config;

    public function __construct()
    {
        $dockerApiVersion = $_ENV['DOCKER_API_VERSION'] ?? self::DEFAULT_DOCKER_API_VERSION;

        $this->config = [
            'base_uri' => "http://{$dockerApiVersion}/",
            'curl' => [
                CURLOPT_UNIX_SOCKET_PATH => '/var/run/docker.sock'
            ]
        ];
    }

    /**
     * @return ClientInterface
     */
    function getClient(): ClientInterface
    {
        return new Client($this->initGuzzle(), new RequestFactoryJson());
    }

    /**
     * @return ClientResponseHandlerInterface
     */
    function getClientWithHandler(): ClientResponseHandlerInterface
    {
        return new ClientResponseHandler($this->getClient());
    }

    /**
     * @return AsyncClientInterface
     */
    function getAsyncClient(): AsyncClientInterface
    {
        return new AsyncClient($this->initGuzzle(), new RequestFactoryJson());
    }

    /**
     * @return AsyncClientResponseHandlerInterface
     */
    function getAsyncClientWithHandler(): AsyncClientResponseHandlerInterface
    {
        return new AsyncClientResponseHandler($this->getAsyncClient());
    }

    /**
     * Default init with Guzzle
     *
     * @return \GuzzleHttp\Client
     */
    protected function initGuzzle(): \GuzzleHttp\Client
    {
        return new \GuzzleHttp\Client($this->config);
    }
}