<?php

namespace Tienvx\PactPhpProtobuf\Consumer\Driver\Interaction;

use PhpPact\Consumer\Driver\Interaction\Contents\ContentsDriverInterface;
use PhpPact\Consumer\Driver\Interaction\MessageDriver;
use PhpPact\Consumer\Driver\Pact\PactDriverInterface;
use PhpPact\FFI\ClientInterface;
use Tienvx\PactPhpProtobuf\Consumer\Driver\Interaction\Contents\ProtobufMessageContentsDriver;

class ProtobufMessageDriver extends MessageDriver
{
    public function __construct(
        ClientInterface $client,
        PactDriverInterface $pactDriver,
        ?ContentsDriverInterface $messageContentsDriver = null
    ) {
        parent::__construct($client, $pactDriver, $messageContentsDriver ?? new ProtobufMessageContentsDriver($client, $this));
    }
}
