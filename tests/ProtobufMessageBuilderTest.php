<?php

namespace Tienvx\PactPhpProtobuf\Tests;

use PhpPact\Standalone\MockService\MockServerConfig;
use PhpPact\Standalone\MockService\MockServerConfigInterface;
use PHPUnit\Framework\TestCase;
use Tienvx\PactPhpProtobuf\ProtobufMessageBuilder;
use Tienvx\PactPhpPlugin\Exception\PluginNotSupportedBySpecificationException;

class ProtobufMessageBuilderTest extends TestCase
{
    private MockServerConfigInterface $config;

    protected function setUp(): void
    {
        $this->config = new MockServerConfig();
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
        new ProtobufMessageBuilder($this->config);
    }

    public function testPluginSupportedBySpecification(): void
    {
        $this->config->setPactSpecificationVersion('4.0.0');
        \putenv('PACT_PLUGIN_DIR=/home');
        new ProtobufMessageBuilder($this->config);
        $this->assertSame(realpath(__DIR__.'/../bin/pact-plugins'), realpath(\getenv('PACT_PLUGIN_DIR')));
    }
}
