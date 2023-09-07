<?php declare(strict_types=1);

namespace Lowel\Docker\Requests;

use JsonException;
use Lowel\Docker\Exceptions\Requests\UriParamWasNotFounded;
use function preg_match_all;
use function str_replace, http_build_query;

class RequestBuilder
{
    /**
     * @param string $method
     * @param string $uri
     * @param array $headers
     * @param string $body
     * @param string $version
     */
    function __construct(
        readonly string $method = '',
        readonly string $uri = '',
        readonly array $headers = [],
        readonly string $body = '',
        readonly string $version = '1.1'
    )
    {}

    /**
     * @param RequestBuilder $cloneable
     * @param string|null $method
     * @param string|null $uri
     * @param array|null $headers
     * @param string|null $body
     * @param string|null $version
     * @return self
     */
    private function clone(
        self $cloneable,
        ?string $method = null,
        ?string $uri = null,
        ?array $headers = null,
        ?string $body = null,
        ?string $version = null
    ): self
    {
        return new self(
            $method ?? $cloneable->method,
            $uri ?? $cloneable->uri,
            $headers ?? $cloneable->headers,
            $body ?? $cloneable->body,
            $version ?? $cloneable->version
        );
    }

    /**
     * @param string $method
     * @return RequestBuilder
     */
    public function setMethod(string $method): self
    {
        return $this->clone($this, method: $method);
    }

    /**
     * @param array<string, mixed> $params
     * @return self
     */
    public function setUriQueryParams(array $params): self
    {
        return $this->setUri("{$this->uri}?" . http_build_query($params));
    }

    /**
     * Set uri with given params
     *
     * @param string $uri
     * @param array $params
     * @return RequestBuilder
     */
    public function setUri(string $uri, array $params = []): self
    {
        return $this->clone($this, uri: $this->uriFormatter($uri, $params));
    }

    /**
     * @param array $headers
     * @return RequestBuilder
     */
    public function setHeaders(array $headers): self
    {
        return $this->clone($this, headers: $headers);
    }

    /**
     * @param array $body
     * @return self
     * @throws JsonException
     */
    public function setBodyJson(array $body): self
    {
        $body = array_filter($body, fn($x) => $x !== null);

        $json = json_encode($body);

        if ($json === false) {
            throw new JsonException(print_r($body, true));
        }

        return $this
            ->setHeaders(['Content-Type' => 'application/json'])
            ->setBody($json);
    }

    /**
     * @param array $body
     * @return self
     */
    public function setBodyWithQueryParams(array $body): self
    {
        $queryParams = http_build_query($body);

        return $this
            ->setHeaders(['Content-Type' => 'application/x-www-form-urlencoded'])
            ->setBody($queryParams);
    }

    /**
     * @param string $body
     * @return RequestBuilder
     */
    public function setBody(string $body): self
    {
        return $this->clone($this, body: $body);
    }

    /**
     * @param string $version
     * @return RequestBuilder
     */
    public function setVersion(string $version): self
    {
        return $this->clone($this, version: $version);
    }

    /**
     * @param string $uri
     * @param array $params
     * @return string
     */
    public function uriFormatter(string $uri, array $params): string
    {
        preg_match_all('/{([^{}]+)}/', $uri, $matches);

        foreach ($matches[1] as $paramName) {
            $paramValue = $params[$paramName]
                ?? throw new UriParamWasNotFounded($uri, $paramName, $params);

            $uri = str_replace("{{$paramName}}", (string)$paramValue, $uri);
        }

        return $uri;
    }
}