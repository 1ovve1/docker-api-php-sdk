<?php declare(strict_types=1);

namespace Lowel\Docker\Response\DTO;

/**
 * https://docs.docker.com/engine/api/v1.41/#tag/Container/operation/ContainerList
 *
 * @property string id
 * @property array<string> names
 * @property string image
 * @property string imageID
 * @property string command,
 * @property int created
 * @property string state
 * @property string status
 * @property array<array{PrivatePort: int, PublicPort: int, Type: string}> ports
 * @property array<string, string> labels
 * @property int sizeRw
 * @property int sizeRootFs
 * @property array<string, int|string> hostConfig
 * @property array{
 *     Networks:
 *          array<array{
 *              NetworkID: string,
 *              EndpointID: string,
 *              Gateway: string,
 *              IPAddress: string,
 *              IPPrefixLen: int,
 *              IPv6Gateway: string,
 *              GlobalIPv6Address: string,
 *              GlobalIPv6PrefixLen: int,
 *              MacAddress: string,
 *          }
 *     >} networks
 *
 * @property array<array{
 *     Name: string,
 *     Source: string,
 *     Destination: string,
 *     Driver: string,
 *     Mode: string,
 *     RW: bool,
 *     Propagination: string}> mounts
 */
class ContainerListItem extends DTO
{
    /**
     * @return string
     */
    function getStatus(): string
    {
        return $this->state['Status'];
    }
}