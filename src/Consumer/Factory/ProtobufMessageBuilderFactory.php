<?php

namespace Tienvx\PactPhpProtobuf\Consumer\Factory;

use PhpPact\Config\PactConfigInterface;
use PhpPact\Consumer\MessageBuilder;
use PhpPact\Consumer\Service\MessageRegistry;
use PhpPact\FFI\Client;
use Tienvx\PactPhpProtobuf\Consumer\Driver\Interaction\ProtobufMessageDriver;
use Tienvx\PactPhpProtobuf\Consumer\Driver\Pact\ProtobufPactDriver;

class ProtobufMessageBuilderFactory
{
    public static function create(PactConfigInterface $config): MessageBuilder
    {
        $client = new Client();
        $pactDriver = new ProtobufPactDriver($client, $config);
        $messageDriver = new ProtobufMessageDriver($client, $pactDriver);
        $messageRegistry = new MessageRegistry($messageDriver);

        return new MessageBuilder($messageRegistry);
    }
}
