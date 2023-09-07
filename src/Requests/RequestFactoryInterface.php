<?php declare(strict_types=1);

namespace Lowel\Docker\Requests;

use Psr\Http\Message\RequestInterface;

interface RequestFactoryInterface
{
    /**
     * @param RequestTypeEnum $requestTypeEnum
     * @param array $params
     * @param $data
     * @return RequestInterface
     */
    function get(RequestTypeEnum $requestTypeEnum, array $params, $data): RequestInterface;

    /**
     * @param RequestTypeEnum $requestTypeEnum
     * @param array $params
     * @param $data
     * @return RequestInterface
     */
    function post(RequestTypeEnum $requestTypeEnum, array $params, $data): RequestInterface;
}