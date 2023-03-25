<?php

namespace App\AsyncMessage\Consumer\Service;

class SayHelloService
{
    public function sayHello(string $given, string $surname): void
    {
        print "Hello {$given} {$surname}";
    }
}
