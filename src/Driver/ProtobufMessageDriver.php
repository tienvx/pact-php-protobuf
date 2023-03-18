<?php

namespace Tienvx\PactPhpProtobuf\Driver;

use PhpPact\Consumer\Driver\MessageDriver;
use PhpPact\Config\PactConfigInterface;
use Tienvx\PactPhpPlugin\Driver\UsingPluginTrait;

class ProtobufMessageDriver extends MessageDriver
{
    use UsingPluginTrait;

    public function __construct(PactConfigInterface $config)
    {
        parent::__construct($config);
        $this
            ->setPluginDir()
            ->usingPlugin();
    }

    protected function cleanUp(): void
    {
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
}
