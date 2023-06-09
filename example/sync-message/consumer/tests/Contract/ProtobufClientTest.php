<?php

namespace App\SyncMessage\Consumer\Tests\Contract;

use App\SyncMessage\Consumer\ProtobufClient;
use PhpPact\Standalone\MockService\MockServerConfig;
use PHPUnit\Framework\TestCase;
use Plugins\Rectangle;
use Plugins\ShapeMessage;
use Tienvx\PactPhpPlugin\Consumer\SyncMessageBuilder;
use Tienvx\PactPhpProtobuf\Consumer\Factory\ProtobufSyncMessageDriverFactory;

class ProtobufClientTest extends TestCase
{
    public function testCalculateArea(): void
    {
        $protoPath = __DIR__ . '/../../../library/proto/area_calculator.proto';

        $config = new MockServerConfig();
        $config->setConsumer('protobufConsumer');
        $config->setProvider('protobufProvider');
        $config->setPactSpecificationVersion('4.0.0');
        $config->setPactDir(__DIR__.'/pacts');
        if ($logLevel = \getenv('PACT_LOGLEVEL')) {
            $config->setLogLevel($logLevel);
        }
        $config->setHost('127.0.0.1');
        $builder = new SyncMessageBuilder($config, new ProtobufSyncMessageDriverFactory());
        $builder
            ->expectsToReceive('request for calculate shape area')
            ->withMetadata([])
            ->withContent([
                'pact:proto' => $protoPath,
                'pact:content-type' => 'application/grpc',
                'pact:proto-service' => 'Calculator/calculate',

                'request' => [
                    'rectangle' => [
                        'length' => 'matching(number, 3)',
                        'width' => 'matching(number, 4)',
                    ],
                ],
                'response' => [
                    'value' => 'matching(number, 12)',
                ]
            ])
            ->withContentType('application/grpc');
        $builder->registerMessage();

        $service = new ProtobufClient("{$config->getHost()}:{$config->getPort()}");
        $rectangle = (new Rectangle())->setLength(3)->setWidth(4);
        $message = (new ShapeMessage())->setRectangle($rectangle);
        $response = $service->calculate($message);

        $this->assertTrue($builder->verify());
        $this->assertEquals(3 * 4, $response->getValue());
    }
}
