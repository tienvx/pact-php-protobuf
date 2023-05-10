<?php

namespace App\AsyncMessage\Consumer\Tests;

use App\AsyncMessage\Consumer\MessageHandler\PersonMessageHandler;
use App\AsyncMessage\Consumer\Service\SayHelloService;
use Library\Person;
use PhpPact\Standalone\PactMessage\PactMessageConfig;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Tienvx\PactPhpProtobuf\Consumer\Factory\ProtobufMessageBuilderFactory;

class PersonMessageHandlerTest extends TestCase
{
    private SayHelloService $service;
    private string $given = 'Given';
    private string $surname = 'Surname';

    protected function setUp(): void
    {
        $service = $this->createMock(SayHelloService::class);
        $service
            ->expects($this->once())
            ->method('sayHello')
            ->with($this->given, $this->surname);
        $this->service = $service;
    }

    public function testInvoke(): void
    {
        $id = 'd1f077b5-0f91-40aa-b8f9-568b50ee4dd9';

        $config = (new PactMessageConfig())
            ->setConsumer('protobufMessageConsumer')
            ->setProvider('protobufMessageProvider')
            ->setPactSpecificationVersion('4.0.0')
            ->setPactDir(__DIR__.'/pacts');
        if ($logLevel = \getenv('PACT_LOGLEVEL')) {
            $config->setLogLevel($logLevel);
        }

        $builder = ProtobufMessageBuilderFactory::create($config);

        $builder
            ->given('A person with fixed id exists', ['id' => $id, 'reuse' => '0'])
            ->expectsToReceive('Person message sent')
            ->withContent([
                'pact:proto' => __DIR__ . '/../../../library/proto/say_hello.proto',
                'pact:message-type' => 'Person',
                'pact:content-type' => 'application/protobuf',
                'id' => "matching(regex, '^[0-9a-f]{8}(-[0-9a-f]{4}){3}-[0-9a-f]{12}$', '{$id}')",
                'name' => [
                    'given' => "matching(type, '{$this->given}')",
                    'surname' => "matching(type, '{$this->surname}')"
                ],
            ])
            ->withContentType('application/protobuf');

        $builder->setCallback(function (string $pactJson): void {
            $message = \json_decode($pactJson);
            $person = new Person();
            $decoded = base64_decode($message->contents->content);
            $person->mergeFromString($decoded);
            $handler = new PersonMessageHandler($this->service);
            $handler($person);
        });

        $this->assertTrue($builder->verify());
    }
}
