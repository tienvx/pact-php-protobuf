<?php

namespace Tienvx\PactPhpProtobuf\Driver;

use PhpPact\Consumer\Driver\AbstractMessageDriver;
use PhpPact\Consumer\Driver\HasMockServerTrait;
use PhpPact\Standalone\MockService\MockServerConfigInterface;
use Tienvx\PactPhpPlugin\Driver\SyncMessageDriverInterface;
use PhpPact\Consumer\Model\Message;
use Tienvx\PactPhpPlugin\Driver\UsingPluginTrait;

class ProtobufSyncMessageDriver extends AbstractMessageDriver implements SyncMessageDriverInterface
{
    use HasMockServerTrait;
    use UsingPluginTrait;

    public function __construct(MockServerConfigInterface $config)
    {
        parent::__construct($config);
        $this
            ->setPluginDir()
            ->usingPlugin();
    }

    protected function getMockServerTransport(): string
    {
        return 'grpc';
    }

    protected function getMockServerConfig(): MockServerConfigInterface
    {
        /** @phpstan-ignore-next-line */
        return $this->config;
    }

    public function verifyMessage(): bool
    {
        return $this->mockServerMatched();
    }

    protected function cleanUp(): void
    {
        $this->cleanUpMockServer();
        $this->cleanUpPlugin();
        parent::cleanUp();
    }

    protected function getPluginName(): string
    {
        return 'protobuf';
    }

    protected function getPluginDir(): string
    {
        return __DIR__.'/../../bin/pact-plugins';
    }

    public function registerMessage(Message $message): void
    {
        parent::registerMessage($message);

        $this->createMockServer();
    }

    protected function newInteraction(string $description): self
    {
        /** @phpstan-ignore-next-line */
        $this->interactionId = $this->ffi->pactffi_new_sync_message_interaction($this->pactId, $description);

        return $this;
    }

    protected function writePact(): void
    {
        $this->mockServerWritePact();
    }
}
