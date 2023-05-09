<?php

namespace Tienvx\PactPhpProtobuf\Consumer\Driver\Pact;

use Tienvx\PactPhpPlugin\Consumer\Driver\Pact\AbstractPluginPactDriver;

class ProtobufPactDriver extends AbstractPluginPactDriver
{
    protected function getPluginName(): string
    {
        return 'protobuf';
    }

    protected function getPluginDir(): string
    {
        return __DIR__.'/../../../../bin/pact-plugins';
    }
}
