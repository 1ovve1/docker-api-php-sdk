<?php declare(strict_types=1);

namespace Lowel\Docker;

use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Message\ResponseInterface;

interface ClientInterface
{
    /**
     * Return list of containers
     *
     * @param bool $all - Return all containers. By default, only running containers are shown.
     * @param int|null $limit - Return this number of most recently created containers, including non-running ones.
     * @param bool $size - Return the size of container as fields SizeRw and SizeRootFs.
     * @param string|null $filters - Filters to process on the container list, encoded as JSON (a map[string][]string). For example, {"status": ["paused"]} will only return paused containers.
     *
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     */
    function containerList(
        bool $all = false,
        ?int $limit = null,
        bool $size = false,
        ?string $filters = null
    ): ResponseInterface;

    /**
     * Inspect for specific container
     *
     * @param string $id - ID or name of the container
     * @param bool $size - Return the size of container as fields SizeRw and SizeRootFs
     *
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     */
    function containerInspect(
        string $id,
        bool $size = false
    ): ResponseInterface;

    /**
     * Start specific container
     *
     * @param string $id - ID or name of the container
     * @param string|null $detachKeys - Override the key sequence for detaching a container. Format is a single character [a-Z] or ctrl-<value> where <value> is one of: a-z, @, ^, [, , or _.
     *
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     */
    function containerStart(
        string $id,
        ?string $detachKeys = null
    ): ResponseInterface;

    /**
     * Stop specific container
     *
     * @param string $id - ID or name of the container
     * @param string|null $signal - Signal to send to the container as an integer or string (e.g. SIGINT).
     * @param int|null $t - Number of seconds to wait before killing the container
     *
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     */
    function containerStop(
        string $id,
        ?string $signal = null,
        ?int $t = null
    ): ResponseInterface;

    /**
     * Restart specific container
     *
     * @param string $id - ID or name of the container
     * @param string|null $signal - Signal to send to the container as an integer or string (e.g. SIGINT).
     * @param int|null $t - Number of seconds to wait before killing the container
     *
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     */
    function containerRestart(
        string $id,
        ?string $signal = null,
        ?int $t = null
    ): ResponseInterface;
}