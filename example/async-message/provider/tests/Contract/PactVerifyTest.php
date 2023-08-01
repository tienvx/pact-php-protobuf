<?php

namespace App\AsyncMessage\Provider\Tests\Contract;

use GuzzleHttp\Psr7\Uri;
use PhpPact\Standalone\ProviderVerifier\Model\VerifierConfig;
use PhpPact\Standalone\ProviderVerifier\Verifier;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Process\Process;

class PactVerifyTest extends TestCase
{
    private Process $process;
    private int $port;

    protected function setUp(): void
    {
        $this->process = new Process(['php', '-S', 'localhost:0', '-t', __DIR__.'/../../public/']);

        $this->process->start();
        $this->process->waitUntil(function (string $type, string $output): bool {
            $result = preg_match('/Development Server \(http:\/\/localhost:(\d+)\) started/', $output, $matches);
            if ($result === 1) {
                $this->port = (int)$matches[1];
            }

            return (bool) $result;
        });
    }

    protected function tearDown(): void
    {
        $this->process->stop();
    }

    public function testPactVerifyConsumer(): void
    {
        $config = new VerifierConfig();
        $config->getProviderInfo()
            ->setName('protobufMessageProvider')
            ->setHost('localhost')
            ->setPort($this->port);
        $config->getProviderState()
            ->setStateChangeUrl(new Uri("http://localhost:{$this->port}/pact-change-state"))
            ->setStateChangeTeardown(true)
            ->setStateChangeAsBody(true)
        ;
        if ($logLevel = \getenv('PACT_LOGLEVEL')) {
            $config->setLogLevel($logLevel);
        }

        $verifier = new Verifier($config);
        $verifier->addDirectory(__DIR__.'/../../../broker/pacts');

        $this->assertTrue($verifier->verify());
    }
}
