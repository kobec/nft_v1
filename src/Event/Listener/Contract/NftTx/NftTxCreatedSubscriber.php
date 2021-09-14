<?php

declare(strict_types=1);

namespace App\Event\Listener\Contract\NftTx;

use App\Model\Contract\Entity\NftTx\Event\NftTxCreatedEvent;
use App\Model\Contract\UseCase\Nft\CreateByNftTxTransactionCallBack\Command;
use Infrastructure\CommandHandling\CommandBusInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class NftTxCreatedSubscriber implements EventSubscriberInterface
{

    private CommandBusInterface $commandBus;

    public function __construct(CommandBusInterface $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            NftTxCreatedEvent::class => 'onNftCreated',
        ];
    }

    public function onNftCreated(NftTxCreatedEvent $event): void
    {
        $cmd = new Command($event->getContractId(), $event->getContractTokenId());
        $this->commandBus->dispatch($cmd);
    }
}