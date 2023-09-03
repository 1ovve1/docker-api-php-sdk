<?php declare(strict_types=1);

namespace Lowel\Docker\Requests;

use function str_replace;

enum RequestTypeEnum: string
{
    /**
     * https://docs.docker.com/engine/api/v1.43/#tag/Container/operation/ContainerList
     */
    case CONTAINER_LIST = "/containers/json";

    /**
     * https://docs.docker.com/engine/api/v1.43/#tag/Container/operation/ContainerInspect
     */
    case CONTAINER_INSPECT = "/containers/{id}/json";

    /**
     * https://docs.docker.com/engine/api/v1.43/#tag/Container/operation/ContainerStart
     */
    case CONTAINER_START = "/containers/{id}/start";

    /**
     * https://docs.docker.com/engine/api/v1.43/#tag/Container/operation/ContainerStop
     */
    case CONTAINER_STOP = "/containers/{id}/stop";

    /**
     * https://docs.docker.com/engine/api/v1.43/#tag/Container/operation/ContainerRestart
     */
    case CONTAINER_RESTART = "/containers/{id}/restart";
}