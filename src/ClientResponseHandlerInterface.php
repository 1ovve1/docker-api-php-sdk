<?php declare(strict_types=1);

namespace Lowel\Docker;

use Lowel\Docker\Exceptions\ContainerAlreadyStartedException;
use Lowel\Docker\Exceptions\ContainerAlreadyStoppedException;
use Lowel\Docker\Exceptions\ContainerNotFoundException;
use Lowel\Docker\Exceptions\DockerClientException;
use Lowel\Docker\Exceptions\DockerClientInvalidParamsException;
use Lowel\Docker\Response\DTO\Container;
use Lowel\Docker\Response\DTO\ContainerListItem;

interface ClientResponseHandlerInterface
{
    /**
     * Return list of containers
     *
     * @param bool $all - Return all containers. By default, only running containers are shown.
     * @param int|null $limit - Return this number of most recently created containers, including non-running ones.
     * @param bool $size - Return the size of container as fields SizeRw and SizeRootFs.
     * @param string|null $filters - Filters to process on the container list, encoded as JSON (a map[string][]string). For example, {"status": ["paused"]} will only return paused containers.
     *
     * @return array<ContainerListItem>
     * @throws DockerClientException|DockerClientInvalidParamsException
     */
    function containerList(
        bool    $all = false,
        ?int    $limit = null,
        bool    $size = false,
        ?string $filters = null
    ): array;

    /**
     * Inspect for specific container
     *
     * @param string $id - ID or name of the container
     * @param bool $size - Return the size of container as fields SizeRw and SizeRootFs
     *
     * @return Container
     * @throws DockerClientException|ContainerNotFoundException|DockerClientInvalidParamsException
     */
    function containerInspect(
        string $id,
        bool   $size = false
    ): Container;

    /**
     * Start specific container
     *
     * @param string $id - ID or name of the container
     * @param string|null $detachKeys - Override the key sequence for detaching a container. Format is a single character [a-Z] or ctrl-<value> where <value> is one of: a-z, @, ^, [, , or _.
     *
     * @return true
     * @throws DockerClientException|ContainerNotFoundException|ContainerAlreadyStartedException|DockerClientInvalidParamsException
     */
    function containerStart(
        string  $id,
        ?string $detachKeys = null
    ): bool;

    /**
     * Stop specific container
     *
     * @param string $id - ID or name of the container
     * @param string|null $signal - Signal to send to the container as an integer or string (e.g. SIGINT).
     * @param int|null $t - Number of seconds to wait before killing the container
     *
     * @return true
     * @throws DockerClientException|ContainerNotFoundException|ContainerAlreadyStoppedException|DockerClientInvalidParamsException
     */
    function containerStop(
        string  $id,
        ?string $signal = null,
        ?int    $t = null
    ): bool;

    /**
     * Restart specific container
     *
     * @param string $id - ID or name of the container
     * @param string|null $signal - Signal to send to the container as an integer or string (e.g. SIGINT).
     * @param int|null $t - Number of seconds to wait before killing the container
     *
     * @return true
     * @throws DockerClientException|ContainerNotFoundException|DockerClientInvalidParamsException
     */
    function containerRestart(
        string  $id,
        ?string $signal = null,
        ?int    $t = null
    ): bool;
}