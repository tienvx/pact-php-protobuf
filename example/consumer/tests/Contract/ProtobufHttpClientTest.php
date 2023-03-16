<?php

namespace App\Consumer\Tests;

use App\Consumer\ProtobufHttpClient;
use PhpPact\Consumer\Model\ConsumerRequest;
use PhpPact\Consumer\Model\ProviderResponse;
use PhpPact\Standalone\MockService\MockServerConfig;
use PHPUnit\Framework\TestCase;
use Plugins\Rectangle;
use Plugins\ShapeMessage;
use Tienvx\PactPhpProtobuf\ProtobufMessageBuilder;

class ProtobufHttpClientTest extends TestCase
{
    public function testCalculateArea()
    {
        $protoPath = __DIR__ . '/../../../library/proto/area_calculator.proto';
        $request = new ConsumerRequest();
        $request
            ->setMethod('POST')
            ->setPath('/calculate')
            ->setBody([
                'pact:proto' => $protoPath,
                'pact:proto-service' => 'Calculator/calculate:request',
                'rectangle' => [
                    'length' => 'matching(number, 3)',
                    'width' => 'matching(number, 4)',
                ],
            ])
            ->setContentType('application/protobuf');

        $response = new ProviderResponse();
        $response
            ->setStatus(200)
            ->setBody([
                'pact:proto' => $protoPath,
                'pact:proto-service' => 'Calculator/calculate:response',
                'value' => 'matching(number, 12)',
            ])
            ->setContentType('application/protobuf');

        $config = new MockServerConfig();
        $config->setConsumer('protobufConsumer');
        $config->setProvider('protobufProvider');
        $config->setPactSpecificationVersion('4.0.0');
        $config->setPactDir(__DIR__.'/pacts');
        if ($logLevel = \getenv('PACT_LOGLEVEL')) {
            $config->setLogLevel($logLevel);
        }
        $builder = new ProtobufMessageBuilder($config);
        $builder
            ->uponReceiving('request for calculate shape area')
            ->with($request)
            ->willRespondWith($response);

        $service = new ProtobufHttpClient($config->getBaseUri());
        $rectangle = (new Rectangle())->setLength(3)->setWidth(4);
        $message = (new ShapeMessage())->setRectangle($rectangle);
        $response = $service->calculate($message);

        $this->assertTrue($builder->verify());
        $this->assertEquals(3 * 4, $response->getValue());
    }
}
