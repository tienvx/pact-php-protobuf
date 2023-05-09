<?php

namespace Tienvx\PactPhpProtobuf\Consumer\Driver\Interaction\Contents;

use PhpPact\Consumer\Driver\Interaction\MessageDriverInterface;
use PhpPact\Consumer\Driver\Interaction\Part\RequestPartTrait;
use PhpPact\FFI\ClientInterface;
use Tienvx\PactPhpPlugin\Consumer\Driver\Interaction\Contents\AbstractContentsDriver;

class ProtobufMessageContentsDriver extends AbstractContentsDriver
{
    use RequestPartTrait;

    public function __construct(
        protected ClientInterface $client,
        private MessageDriverInterface $messageDriver
    ) {
        parent::__construct($client);
    }

    protected function getInteractionId(): int
    {
        return $this->messageDriver->getId();
    }
}
