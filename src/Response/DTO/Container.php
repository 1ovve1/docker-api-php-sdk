<?php declare(strict_types=1);

namespace Lowel\Docker\Response\DTO;

/**
 * https://docs.docker.com/engine/api/v1.41/#tag/Container/operation/ContainerInspect
 *
 * @property string appArmorProfile
 * @property array<string, string> args
 * @property array<string, mixed> config
 * @property string created
 * @property string driver
 * @property array<string> execIDs
 * @property array<string, mixed> hostConfig
 * @property string hostnamePath
 * @property string hostsPath
 * @property string logPath
 * @property string id
 * @property string image
 * @property string mountLabel
 * @property string name
 * @property array<string, mixed> networkSettings
 * @property string path
 * @property string processLabel
 * @property string resolvConfPath
 * @property int restartCount
 * @property array{
 *     Error: string,
 *     ExitCode: int,
 *     FinishiedAt: string,
 *     Health: array {
 *          Status: string,
 *          FailingSteak: int,
 *          Log: array<array<string, int|string>>
 *     },
 *     OOMKilled: bool,
 *     Dead: bool,
 *     Paused: bool,
 *     Pid: int,
 *     Restarting: bool,
 *     Running: bool,
 *     StartedAt: string,
 *     Status: string
 * } state
 * @property array<array<string, string|bool> mounts
 */
class Container extends DTO
{
    /**
     * @return bool
     */
    function isDead(): bool
    {
        return $this->state['Dead'];
    }

    /**
     * @return bool
     */
    function isRestarting(): bool
    {
        return $this->state['Restarting'];
    }

    /**
     * @return bool
     */
    function isRunning(): bool
    {
        return $this->state['Running'];
    }

    /**
     * @return bool
     */
    function isPaused(): bool
    {
        return $this->state['Paused'];
    }

    /**
     * @return bool
     */
    function isStopped(): bool
    {
        return $this->getStatus() === 'exited';
    }
    
    /**
     * @return string
     */
    function getStatus(): string
    {
        return $this->state['Status'];
    }
}