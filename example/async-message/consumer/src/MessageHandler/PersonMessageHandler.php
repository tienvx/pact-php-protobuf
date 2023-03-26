<?php

namespace App\AsyncMessage\Consumer\MessageHandler;

use App\AsyncMessage\Consumer\Service\SayHelloService;
use Library\Person;

class PersonMessageHandler
{
    public function __construct(private SayHelloService $service)
    {
    }

    public function __invoke(Person $person): void
    {
        $this->service->sayHello($person->getName()->getGiven(), $person->getName()->getSurname());
    }
}
