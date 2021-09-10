<?php

declare(strict_types=1);

namespace Infrastructure\Dispatchers\Symfony;

use Infrastructure\Dispatchers\EventDispatcherInterface;
use Infrastructure\Dispatchers\Symfony\Message\Message;
use Symfony\Component\Messenger\MessageBusInterface;

class MessengerEventDispatcher implements EventDispatcherInterface
{
    private $bus;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }

    public function dispatch($event): void
    {
        $this->bus->dispatch(new Message($event));
    }

    public function dispatchAll(array $events): void
    {
        foreach ($events as $event) {
            $this->dispatch($event);
        }
    }
}
