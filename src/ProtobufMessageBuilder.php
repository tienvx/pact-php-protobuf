<?php

namespace Tienvx\PactPhpProtobuf;

use PhpPact\Consumer\InteractionBuilder;
use PhpPact\Consumer\Model\Interaction;
use PhpPact\Standalone\MockService\MockServerConfigInterface;
use Tienvx\PactPhpPlugin\Model\PactPlugin;

class ProtobufMessageBuilder extends InteractionBuilder
{
    public function __construct(MockServerConfigInterface $config)
    {
        $this->interaction = new Interaction();
        $this->pact = new PactPlugin($config);
        $this->setPluginDir();
        $this->pact->usingPlugin('protobuf');
    }

    private function setPluginDir(): void
    {
        $pluginDir = __DIR__.'/../bin/pact-plugins';
        \putenv("PACT_PLUGIN_DIR={$pluginDir}");
    }
}
