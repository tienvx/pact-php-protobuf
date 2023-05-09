<?php

namespace Tienvx\PactPhpProtobuf\Consumer\Service;

use PhpPact\Consumer\Service\MockServer;

class GrpcMockServer extends MockServer
{
    protected function getTransport(): string
    {
        return 'grpc';
    }
}
