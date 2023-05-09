<?php

namespace Tienvx\PactPhpProtobuf\Consumer\Factory;

use PhpPact\FFI\Client;
use PhpPact\Standalone\MockService\MockServerConfigInterface;
use Tienvx\PactPhpPlugin\Consumer\Service\SyncMessageRegistry;
use Tienvx\PactPhpPlugin\Consumer\SyncMessageBuilder;
use Tienvx\PactPhpProtobuf\Consumer\Driver\Interaction\ProtobufSyncMessageDriver;
use Tienvx\PactPhpProtobuf\Consumer\Driver\Pact\ProtobufPactDriver;
use Tienvx\PactPhpProtobuf\Consumer\Service\GrpcMockServer;

class ProtobufSyncMessageBuilderFactory
{
    public static function create(MockServerConfigInterface $config): SyncMessageBuilder
    {
        $client = new Client();
        $pactDriver = new ProtobufPactDriver($client, $config);
        $messageDriver = new ProtobufSyncMessageDriver($client, $pactDriver);
        $grpcMockServer = new GrpcMockServer($client, $pactDriver, $config);
        $syncMessageRegistry = new SyncMessageRegistry($messageDriver, $grpcMockServer);

        return new SyncMessageBuilder($syncMessageRegistry);
    }
}
