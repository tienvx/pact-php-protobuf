<?php

use App\Provider\Service\Calculator;
use App\Provider\Service\CalculatorInterface;
use Spiral\RoadRunner\GRPC\Server;
use Spiral\RoadRunner\Worker;

require __DIR__ . '/../../vendor/autoload.php';

$server = new Server(null, [
    'debug' => false, // optional (default: false)
]);

$server->registerService(CalculatorInterface::class, new Calculator());

$server->serve(Worker::create());
