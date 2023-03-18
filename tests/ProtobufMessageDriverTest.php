<?php

namespace Tienvx\PactPhpProtobuf\Tests;

use PhpPact\Config\PactConfig;
use PhpPact\Config\PactConfigInterface;
use PHPUnit\Framework\TestCase;
use Tienvx\PactPhpProtobuf\Driver\ProtobufMessageDriver;
use Tienvx\PactPhpPlugin\Exception\PluginNotSupportedBySpecificationException;

class ProtobufMessageDriverTest extends TestCase
{
    private PactConfigInterface $config;

    protected function setUp(): void
    {
        $this->config = new PactConfig();
        $this->config
            ->setConsumer('consumer')
            ->setProvider('provider')
            ->setLogLevel('debug')
        ;
    }

    public function testPluginNotSupportedBySpecification(): void
    {
        $this->config->setPactSpecificationVersion('3.0.0');
        $this->expectException(PluginNotSupportedBySpecificationException::class);
        $this->expectExceptionMessage('Plugin is not supported by specification 3.0.0, use 4.0.0 or above');
        new ProtobufMessageDriver($this->config);
    }

    public function testPluginSupportedBySpecification(): void
    {
        $this->config->setPactSpecificationVersion('4.0.0');
        \putenv('PACT_PLUGIN_DIR=/home');
        new ProtobufMessageDriver($this->config);
        $this->assertSame(realpath(__DIR__.'/../bin/pact-plugins'), realpath(\getenv('PACT_PLUGIN_DIR')));
    }
}
