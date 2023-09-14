# Pact PHP Protobuf Plugin [![Build Status][actions_badge]][actions_link] [![Coverage Status][coveralls_badge]][coveralls_link] [![Version][version-image]][version-url] [![PHP Version][php-version-image]][php-version-url]

This library is a plugin for [Pact PHP][pact-php].
It allow testing protobuf interactions.

## Installation

```shell
composer require tienvx/pact-php-protobuf
```

### Pre-requisites

- gRPC PHP extension. See [docs](https://cloud.google.com/php/grpc) for installation
- Protobuf compiler (protoc). See [docs](https://grpc.io/docs/protoc-installation/) for installation

## Test

```shell
composer install
composer install -d example/sync-message/provider
composer gen-lib
composer test
```

## Documentation

### Async Message

[Consumer Example](./example/async-message/consumer/tests/Contract/PersonMessageHandlerTest.php)
[Provider Example](./example/async-message/provider/tests/Contract/PactVerifyTest.php)

### Sync Message

[Consumer Example](./example/sync-message/consumer/tests/Contract/ProtobufClientTest.php)
[Provider Example](./example/sync-message/provider/tests/Contract/PactVerifyTest.php)

## License

[MIT](https://github.com/tienvx/pact-php-protobuf/blob/main/LICENSE)

[actions_badge]: https://github.com/tienvx/pact-php-protobuf/workflows/main/badge.svg
[actions_link]: https://github.com/tienvx/pact-php-protobuf/actions

[coveralls_badge]: https://coveralls.io/repos/tienvx/pact-php-protobuf/badge.svg?branch=main&service=github
[coveralls_link]: https://coveralls.io/github/tienvx/pact-php-protobuf?branch=main

[version-url]: https://packagist.org/packages/tienvx/pact-php-protobuf
[version-image]: http://img.shields.io/packagist/v/tienvx/pact-php-protobuf.svg?style=flat

[php-version-url]: https://packagist.org/packages/tienvx/pact-php-protobuf
[php-version-image]: http://img.shields.io/badge/php-8.0.0+-ff69b4.svg

[pact-php]: https://github.com/pact-foundation/pact-php
