<?php declare(strict_types=1);

use Lowel\Docker\Requests\RequestBuilder;

beforeEach(function() {
    $this->requestBuilder = new RequestBuilder();
});

test('uri formatter', function () {
    expect($this->requestBuilder->uriFormatter('/test', []))
        ->toBe('/test')

        ->and($this->requestBuilder->uriFormatter('/test/{id}', ['id' => 123]))
        ->toBe('/test/123')

        ->and($this->requestBuilder->uriFormatter('/test/{id}/test/{second_id}', ['second_id' => '12312', 'id' => 123]))
        ->toBe('/test/123/test/12312');
});

test('uri formatter exceptions', function() {
    $this->requestBuilder->uriFormatter('/{id}', []);
})->throws(\Lowel\Docker\Exceptions\Requests\UriParamWasNotFounded::class);

test('uri query params', function() {
    $state = $this->requestBuilder->setUriQueryParams(['a' => 123, 'b' => 456]);

    expect($state->uri)
        ->toBe('?a=123&b=456');
});

test('request builder', function() {
    $requestBuilderState = $this->requestBuilder
        ->setMethod('GET')
        ->setBody('qweqweqwe')
        ->setUri('mew')
        ->setHeaders(['header' => 'data'])
        ->setVersion('2.0');

    expect($requestBuilderState)->not->toBe($this->requestBuilder)
        ->and($requestBuilderState->uri)->toBe('mew')
        ->and($requestBuilderState->method)->toBe('GET')
        ->and($requestBuilderState->headers)->toBe(['header' => 'data'])
        ->and($requestBuilderState->version)->toBe('2.0')
        ->and($requestBuilderState->body)->toBe('qweqweqwe');

});

test('set body json', function() {
    expect($this->requestBuilder->setBodyJson(['data' => 'value'])->body)
        ->toBe(json_encode(['data' => 'value']));
});