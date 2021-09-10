<?php

declare(strict_types=1);

namespace Infrastructure\Dispatchers\Symfony\Message;

class Message
{
    private $event;

    public function __construct(object $event)
    {
        $this->event = $event;
    }

    public function getEvent(): object
    {
        return $this->event;
    }
}
