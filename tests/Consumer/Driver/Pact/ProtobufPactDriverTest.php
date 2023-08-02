<?php

namespace Tienvx\PactPhpProtobuf\Tests;

use PhpPact\Config\PactConfig;
use PhpPact\Config\PactConfigInterface;
use PhpPact\Consumer\Registry\Pact\PactRegistry;
use PhpPact\Consumer\Registry\Pact\PactRegistryInterface;
use PhpPact\FFI\Client;
use PhpPact\FFI\ClientInterface;
use PHPUnit\Framework\TestCase;
use Tienvx\PactPhpPlugin\Consumer\Exception\PluginNotSupportedBySpecificationException;
use Tienvx\PactPhpProtobuf\Consumer\Driver\Pact\ProtobufPactDriver;

class ProtobufPactDriverTest extends TestCase
{
    private ClientInterface $client;
    private PactConfigInterface $config;
    private PactRegistryInterface $pactRegistry;
    private ProtobufPactDriver $pactDriver;

    protected function setUp(): void
    {
        $this->client = new Client();
        $this->config = new PactConfig();
        $this->config
            ->setConsumer('consumer')
            ->setProvider('provider')
            ->setLogLevel('debug')
        ;
        $this->pactRegistry = new PactRegistry($this->client);
        $this->pactDriver = new ProtobufPactDriver($this->client, $this->config, $this->pactRegistry);
    }

    public function testPluginNotSupportedBySpecification(): void
    {
        $this->config->setPactSpecificationVersion('3.0.0');
        $this->expectException(PluginNotSupportedBySpecificationException::class);
        $this->expectExceptionMessage('Plugin is not supported by specification 3.0.0, use 4.0.0 or above');
        $this->pactDriver->setUp();
    }

    public function testPluginSupportedBySpecification(): void
    {
        $this->config->setPactSpecificationVersion('4.0.0');
        $this->expectNotToPerformAssertions();
        $this->pactDriver->setUp();
    }
}
