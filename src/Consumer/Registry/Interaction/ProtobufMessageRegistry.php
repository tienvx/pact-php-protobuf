<?php

namespace Tienvx\PactPhpProtobuf\Consumer\Registry\Interaction;

use PhpPact\Consumer\Registry\Interaction\Contents\ContentsRegistryInterface;
use PhpPact\Consumer\Registry\Interaction\MessageRegistry;
use PhpPact\Consumer\Registry\Pact\PactRegistryInterface;
use PhpPact\FFI\ClientInterface;
use Tienvx\PactPhpProtobuf\Consumer\Registry\Interaction\Contents\ProtobufMessageContentsRegistry;

class ProtobufMessageRegistry extends MessageRegistry
{
    public function __construct(
        ClientInterface $client,
        PactRegistryInterface $pactRegistry,
        ?ContentsRegistryInterface $messageContentsRegistry = null
    ) {
        parent::__construct($client, $pactRegistry, $messageContentsRegistry ?? new ProtobufMessageContentsRegistry($client, $this));
    }
}
