<?php

namespace App\Consumer;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Plugins\AreaResponse;
use Plugins\CalculatorClient;
use Plugins\ShapeMessage;

class ProtobufClient
{
    public function __construct(private string $baseUrl)
    {
    }

    public function calculate(ShapeMessage $shapeMessage): AreaResponse
    {
        $client = new CalculatorClient($this->baseUrl, [
            'credentials' => \Grpc\ChannelCredentials::createInsecure(),
        ]);

        [$response, $status] = $client->calculate($shapeMessage)->wait();

        return $response;
    }
}
