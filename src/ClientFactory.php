<?php declare(strict_types=1);

namespace Lowel\Docker;

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

    function getClient(): ClientInterface
    {
        return new Client(new \GuzzleHttp\Client($this->config));
    }
}