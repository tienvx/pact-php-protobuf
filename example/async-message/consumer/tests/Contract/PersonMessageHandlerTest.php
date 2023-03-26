<?php

namespace App\AsyncMessage\Consumer\Tests;

use App\AsyncMessage\Consumer\MessageHandler\PersonMessageHandler;
use App\AsyncMessage\Consumer\Service\SayHelloService;
use Library\Person;
use PhpPact\Standalone\PactMessage\PactMessageConfig;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Tienvx\PactPhpPlugin\MessageBuilder;
use Tienvx\PactPhpProtobuf\Driver\ProtobufMessageDriver;

class PersonMessageHandlerTest extends TestCase
{
    private SayHelloService|MockObject $service;

    protected function setUp(): void
    {
        $this->service = $this->createMock(SayHelloService::class);
    }

    public function testInvoke(): void
    {
        $id = 'd1f077b5-0f91-40aa-b8f9-568b50ee4dd9';
        $given = 'Given';
        $surname = 'Surname';

        $this->service
            ->expects($this->once())
            ->method('sayHello')
            ->with($given, $surname);

        $config = (new PactMessageConfig())
            ->setConsumer('protobufMessageConsumer')
            ->setProvider('protobufMessageProvider')
            ->setPactSpecificationVersion('4.0.0')
            ->setPactDir(__DIR__.'/pacts');
        if ($logLevel = \getenv('PACT_LOGLEVEL')) {
            $config->setLogLevel($logLevel);
        }

        $builder = new MessageBuilder(new ProtobufMessageDriver($config));

        $builder
            ->given('A person with fixed id exists', ['id' => $id, 'reuse' => '0'])
            ->expectsToReceive('Person message sent')
            ->withContent([
                'pact:proto' => __DIR__ . '/../../../library/proto/say_hello.proto',
                'pact:message-type' => 'Person',
                'pact:content-type' => 'application/protobuf',
                'id' => "matching(regex, '^[0-9a-f]{8}(-[0-9a-f]{4}){3}-[0-9a-f]{12}$', '{$id}')",
                'name' => [
                    'given' => "matching(type, '{$given}')",
                    'surname' => "matching(type, '{$surname}')"
                ],
            ])
            ->withContentType('application/protobuf');

        $builder->setCallback(function (string $pactJson): void {
            $message = \json_decode($pactJson);
            $person = new Person();
            $decoded = base64_decode($message->contents->content);
            $person->mergeFromString($decoded);
            //$person->mergeFromJsonString(\json_encode($message->contents));
            $handler = new PersonMessageHandler($this->service);
            $handler($person);
        });

        $this->assertTrue($builder->verify());
    }
}
