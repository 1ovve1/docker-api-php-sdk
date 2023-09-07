<?php declare(strict_types=1);

namespace Lowel\Docker;

use Lowel\Docker\Exceptions\ContainerAlreadyStartedException;
use Lowel\Docker\Exceptions\ContainerAlreadyStoppedException;
use Lowel\Docker\Exceptions\ContainerNotFoundException;
use Lowel\Docker\Exceptions\DockerClientException;
use Lowel\Docker\Exceptions\DockerClientInvalidParamsException;
use Lowel\Docker\Response\DTO\Container;
use Lowel\Docker\Response\DTOFactory;
use Lowel\Docker\Response\ResponseParser;
use Psr\Http\Client\ClientExceptionInterface;
use Symfony\Component\HttpFoundation\Response;

use function func_get_args;

class ClientResponseHandler implements ClientResponseHandlerInterface
{
    /** @var ClientInterface  */
    protected ClientInterface $client;
    /** @var DTOFactory  */
    protected DTOFactory $dtoFactory;

    /**
     * @param ClientInterface $client
     */
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;

        $this->dtoFactory = new DTOFactory(new ResponseParser());
    }

    /**
     * @inheritDoc
     */
    function containerList(bool $all = false, ?int $limit = null, bool $size = false, ?string $filters = null): array
    {
        try {
            $response = $this->client->containerList(...func_get_args());
        } catch (ClientExceptionInterface $clientException) {
            throw new DockerClientException(previous: $clientException);
        }

        return match($response->getStatusCode()) {
            Response::HTTP_BAD_REQUEST =>
                throw new DockerClientInvalidParamsException(func_get_args(), $response),
            Response::HTTP_INTERNAL_SERVER_ERROR =>
                throw new DockerClientException(),
            Response::HTTP_OK =>
                $this->dtoFactory->createDockerCollectionFromResponse($response)
        };
    }

    /**
     * @inheritDoc
     */
    function containerInspect(string $id, bool $size = false): Container
    {
        try {
            $response = $this->client->containerInspect(...func_get_args());
        } catch (ClientExceptionInterface $clientException) {
            throw new DockerClientException(previous: $clientException);
        }

        return match($response->getStatusCode()) {
            Response::HTTP_NOT_FOUND =>
                throw new ContainerNotFoundException($id),
            Response::HTTP_INTERNAL_SERVER_ERROR =>
                throw new DockerClientException(),
            Response::HTTP_OK =>
                $this->dtoFactory->createContainerFromResponse($response)
        };
    }

    /**
     * @inheritDoc
     */
    function containerStart(string $id, ?string $detachKeys = null): bool
    {
        try {
            $response = $this->client->containerStart(...func_get_args());
        } catch (ClientExceptionInterface $clientException) {
            throw new DockerClientException(previous: $clientException);
        }

        return match($response->getStatusCode()) {
            Response::HTTP_NOT_MODIFIED =>
                throw new ContainerAlreadyStartedException($id),
            Response::HTTP_NOT_FOUND =>
                throw new ContainerNotFoundException($id),
            Response::HTTP_INTERNAL_SERVER_ERROR =>
                throw new DockerClientException(),
            Response::HTTP_NO_CONTENT =>
                true
        };
    }

    /**
     * @inheritDoc
     */
    function containerStop(string $id, ?string $signal = null, ?int $t = null): bool
    {
        try {
            $response = $this->client->containerStop(...func_get_args());
        } catch (ClientExceptionInterface $clientException) {
            throw new DockerClientException(previous: $clientException);
        }

        return match($response->getStatusCode()) {
            Response::HTTP_NOT_MODIFIED =>
                throw new ContainerAlreadyStoppedException($id),
            Response::HTTP_NOT_FOUND =>
                throw new ContainerNotFoundException($id),
            Response::HTTP_INTERNAL_SERVER_ERROR =>
                throw new DockerClientException(),
            Response::HTTP_NO_CONTENT =>
                true
        };
    }

    /**
     * @inheritDoc
     */
    function containerRestart(string $id, ?string $signal = null, ?int $t = null): bool
    {
        try {
            $response = $this->client->containerRestart(...func_get_args());
        } catch (ClientExceptionInterface $clientException) {
            throw new DockerClientException(previous: $clientException);
        }

        return match($response->getStatusCode()) {
            Response::HTTP_NOT_FOUND =>
                throw new ContainerNotFoundException($id),
            Response::HTTP_INTERNAL_SERVER_ERROR =>
                throw new DockerClientException(),
            Response::HTTP_NO_CONTENT =>
                true
        };
    }


}