<?php

namespace Tienvx\PactPhpProtobuf\Consumer\Registry\Interaction;

use PhpPact\Consumer\Registry\Interaction\Contents\ContentsRegistryInterface;
use PhpPact\Consumer\Registry\Pact\PactRegistryInterface;
use PhpPact\FFI\ClientInterface;
use Tienvx\PactPhpPlugin\Consumer\Registry\Interaction\SyncMessageRegistry;
use Tienvx\PactPhpProtobuf\Consumer\Registry\Interaction\Contents\ProtobufMessageContentsRegistry;

class ProtobufSyncMessageRegistry extends SyncMessageRegistry
{
    public function __construct(
        ClientInterface $client,
        PactRegistryInterface $pactRegistry,
        ?ContentsRegistryInterface $messageContentsRegistry = null
    ) {
        parent::__construct($client, $pactRegistry, $messageContentsRegistry ?? new ProtobufMessageContentsRegistry($client, $this));
    }
}
