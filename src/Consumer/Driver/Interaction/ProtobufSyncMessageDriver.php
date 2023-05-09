<?php

namespace Tienvx\PactPhpProtobuf\Consumer\Driver\Interaction;

use PhpPact\Consumer\Driver\Interaction\Contents\ContentsDriverInterface;
use PhpPact\Consumer\Driver\Pact\PactDriverInterface;
use PhpPact\FFI\ClientInterface;
use Tienvx\PactPhpPlugin\Consumer\Driver\Interaction\SyncMessageDriver;
use Tienvx\PactPhpProtobuf\Consumer\Driver\Interaction\Contents\ProtobufMessageContentsDriver;

class ProtobufSyncMessageDriver extends SyncMessageDriver
{
    public function __construct(
        ClientInterface $client,
        PactDriverInterface $pactDriver,
        ?ContentsDriverInterface $messageContentsDriver = null
    ) {
        parent::__construct($client, $pactDriver, $messageContentsDriver ?? new ProtobufMessageContentsDriver($client, $this));
    }
}
