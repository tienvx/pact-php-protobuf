<?php

namespace Tienvx\PactPhpProtobuf\Consumer\Registry\Interaction\Contents;

use PhpPact\Consumer\Registry\Interaction\MessageRegistryInterface;
use PhpPact\Consumer\Registry\Interaction\Part\RequestPartTrait;
use PhpPact\FFI\ClientInterface;
use Tienvx\PactPhpPlugin\Consumer\Registry\Interaction\Contents\AbstractContentsRegistry;

class ProtobufMessageContentsRegistry extends AbstractContentsRegistry
{
    use RequestPartTrait;

    public function __construct(
        protected ClientInterface $client,
        private MessageRegistryInterface $messageRegistry
    ) {
        parent::__construct($client);
    }

    protected function getInteractionId(): int
    {
        return $this->messageRegistry->getId();
    }
}
