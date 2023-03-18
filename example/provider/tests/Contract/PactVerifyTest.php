<?php

namespace App\Tests\Contract;

use PhpPact\Standalone\ProviderVerifier\Model\Config\ProviderTransport;
use PhpPact\Standalone\ProviderVerifier\Model\VerifierConfig;
use PhpPact\Standalone\ProviderVerifier\Verifier;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Process\Process;

class PactVerifyTest extends TestCase
{
    private Process $process;

    protected function setUp(): void
    {
        $this->process = new Process([ __DIR__ . '/../../rr', 'serve', '-w', 'example/provider/']);

        $this->process->start();
        $this->process->waitUntil(function (string $type, string $output): bool {
            return str_contains($output, 'grpc server was started');
        });
    }

    protected function tearDown(): void
    {
        $this->process->stop();
    }

    public function testPactVerifyConsumer()
    {
        $config = new VerifierConfig();
        $config->getProviderInfo()
            ->setName('protobufProvider')
            ->setHost('127.0.0.1');
        $providerTransport = new ProviderTransport();
        $providerTransport
            ->setProtocol('grpc')
            ->setScheme('tcp')
            ->setPort(9001)
            ->setPath('/')
        ;
        $config->addProviderTransport($providerTransport);
        if ($logLevel = \getenv('PACT_LOGLEVEL')) {
            $config->setLogLevel($logLevel);
        }

        $verifier = new Verifier($config);
        $verifier->addDirectory(__DIR__.'/../../../broker/pacts');

        $this->assertTrue($verifier->verify());
    }
}
