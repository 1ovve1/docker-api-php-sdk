<?php declare(strict_types=1);

namespace Lowel\Docker\Requests;

use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\RequestInterface;

class RequestFactory implements RequestFactoryInterface
{
    /** @var RequestBuilder  */
    protected RequestBuilder $requestBuilder;

    public function __construct()
    {
        $this->requestBuilder = new RequestBuilder();
    }


    /**
     * @param RequestTypeEnum $requestTypeEnum
     * @param array $params
     * @param array $data
     * @return RequestInterface
     */
    function get(RequestTypeEnum $requestTypeEnum, array $params, $data): RequestInterface
    {
        return $this->requestFromRequestBuilder(
            $this->requestBuilder
                ->setMethod('GET')
                ->setUri($requestTypeEnum->value, $params)
                ->setUriQueryParams($data)
        );
    }

    /**
     * @param RequestTypeEnum $requestTypeEnum
     * @param array $params
     * @param array $data
     * @return RequestInterface
     */
    function post(RequestTypeEnum $requestTypeEnum, array $params, $data): RequestInterface
    {
        return $this->requestFromRequestBuilder(
            $this->requestBuilder
                ->setMethod('POST')
                ->setUri($requestTypeEnum->value, $params)
                ->setBodyWithQueryParams($data)
        );
    }

    /**
     * @param RequestBuilder $requestBuilder
     * @return RequestInterface
     */
    protected function requestFromRequestBuilder(RequestBuilder $requestBuilder): RequestInterface
    {
        $request = new Request(
            $requestBuilder->method,
            $requestBuilder->uri,
            $requestBuilder->headers,
            $requestBuilder->body,
            $requestBuilder->version
        );

        return $request;
    }
}