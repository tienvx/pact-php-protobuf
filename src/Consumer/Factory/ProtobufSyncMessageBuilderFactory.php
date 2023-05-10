<?php

namespace Tienvx\PactPhpProtobuf\Consumer\Factory;

use PhpPact\Consumer\Registry\Pact\PactRegistry;
use PhpPact\FFI\Client;
use PhpPact\Standalone\MockService\MockServerConfigInterface;
use Tienvx\PactPhpPlugin\Consumer\Driver\Interaction\SyncMessageDriver;
use Tienvx\PactPhpPlugin\Consumer\SyncMessageBuilder;
use Tienvx\PactPhpProtobuf\Consumer\Driver\Pact\ProtobufPactDriver;
use Tienvx\PactPhpProtobuf\Consumer\Registry\Interaction\ProtobufSyncMessageRegistry;
use Tienvx\PactPhpProtobuf\Consumer\Service\GrpcMockServer;

class ProtobufSyncMessageBuilderFactory
{
    public static function create(MockServerConfigInterface $config): SyncMessageBuilder
    {
        $client = new Client();
        $pactRegistry = new PactRegistry($client);
        $pactDriver = new ProtobufPactDriver($client, $config, $pactRegistry);
        $grpcMockServer = new GrpcMockServer($client, $pactRegistry, $config);
        $syncMessageRegistry = new ProtobufSyncMessageRegistry($client, $pactRegistry);
        $messageDriver = new SyncMessageDriver($pactDriver, $syncMessageRegistry, $grpcMockServer);

        return new SyncMessageBuilder($messageDriver);
    }
}
