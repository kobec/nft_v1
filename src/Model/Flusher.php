<?php

declare(strict_types=1);

namespace App\Model;

use Doctrine\ORM\EntityManagerInterface;
use Infrastructure\Dispatchers\EventDispatcherInterface;

class Flusher
{
    private EntityManagerInterface $em;
  //  private EventDispatcherInterface $dispatcher;

    public function __construct(EntityManagerInterface $em, EventDispatcherInterface $dispatcher)
    {
        $this->em = $em;
        $this->dispatcher = $dispatcher;
    }

    public function flush(AggregateRoot ...$roots): void
    {
        $this->em->flush();
        foreach ($roots as $root) {
            $this->dispatcher->dispatchAll($root->releaseEvents());
        }
    }
}
