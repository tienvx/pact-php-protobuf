# Pact PHP Protobuf Plugin [![Build Status][actions_badge]][actions_link] [![Coverage Status][coveralls_badge]][coveralls_link] [![Version][version-image]][version-url] [![PHP Version][php-version-image]][php-version-url]

This library is a plugin for [Pact PHP][pact-php].
It allow testing protobuf interactions.

## Installation

```shell
composer require tienvx/pact-php-protobuf
```

## Test

```shell
composer install
composer install -d example/sync-message/provider
composer gen-lib
composer test
```

## Documentation

TBD

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
