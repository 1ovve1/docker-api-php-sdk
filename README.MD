# Docker Engine API 1.41 SDK based on PHP

## Installation

Current library was tested on docker 1.41 api version! 

```bash
composer require lowel/docker-api-php-sdk
```

## Supported clients

SDK support:
+ Manual PSR-7 client;
+ Manual response handler, that return DTO objects (looks Lowel\Docker\Response\DTO) instead of ResponseInterface and throw some of the custom exceptions from Lowel\Docker\Exceptions;
+ Async client, based on Guzzle library, return promises;
+ Async response handler, same as manual response handler, but return type is promises.

You can init all clients use Lowel\Docker\ClientFactory:

```php
$clientFactory = new \Lowel\Docker\ClientFactory();

$client = $clientFactory->getClient();
$clientWithHandler = $clientFactory->getClientWithHandler();
$asyncClient = $clientFactory->getAsyncClient();
$asyncClientWithHandler = $clientFactory->getAsyncClientWithHandler();

$client->containerList();
$clientWithHandler->containerInspect('container-name');
$asyncClient->containerStart('container-name');
$asyncClientWithHandler->containerStop('container-name');

$asyncClient->wait();
$asyncClientWithHandler->wait();
```

## Configuration

You can switch default docker api version by set DOCKER_API_VERSION global env:
```php
// Client factory use default value '1.41v'
$_ENV['DOCKER_API_VERSION'] = '1.43v'
```

Also you should have /var/run/docker.sock in your system. This is default path for docker socker.
