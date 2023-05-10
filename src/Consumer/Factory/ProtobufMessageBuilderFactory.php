<?php

namespace Tienvx\PactPhpProtobuf\Consumer\Factory;

use PhpPact\Config\PactConfigInterface;
use PhpPact\Consumer\Driver\Interaction\MessageDriver;
use PhpPact\Consumer\MessageBuilder;
use PhpPact\Consumer\Registry\Pact\PactRegistry;
use PhpPact\FFI\Client;
use Tienvx\PactPhpProtobuf\Consumer\Driver\Pact\ProtobufPactDriver;
use Tienvx\PactPhpProtobuf\Consumer\Registry\Interaction\ProtobufMessageRegistry;

class ProtobufMessageBuilderFactory
{
    public static function create(PactConfigInterface $config): MessageBuilder
    {
        $client = new Client();
        $pactRegistry = new PactRegistry($client);
        $pactDriver = new ProtobufPactDriver($client, $config, $pactRegistry);
        $messageRegistry = new ProtobufMessageRegistry($client, $pactRegistry);
        $messageDriver = new MessageDriver($client, $pactDriver, $messageRegistry);

        return new MessageBuilder($messageDriver);
    }
}
