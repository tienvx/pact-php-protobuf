<?php

namespace App\Consumer;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Plugins\AreaResponse;
use Plugins\ShapeMessage;

class ProtobufHttpClient
{
    private HttpClientInterface $client;

    public function __construct(
        private string $baseUrl
    ) {
        $this->client = HttpClient::create([
            'headers' => [
                'Content-Type' => 'application/protobuf;message=ShapeMessage',
            ],
        ]);
    }

    public function calculate(ShapeMessage $request): AreaResponse
    {
        $httpResponse = $this->client->request('POST', "{$this->baseUrl}/calculate", [
            'body' => $request->serializeToString(),
        ]);
        $response = new AreaResponse();
        $response->mergeFromString($httpResponse->getContent());

        return $response;
    }
}
