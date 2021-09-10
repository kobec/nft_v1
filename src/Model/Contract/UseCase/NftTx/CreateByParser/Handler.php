<?php

declare(strict_types=1);

namespace App\Model\Contract\UseCase\NftTx\CreateByParser;

use Infrastructure\CommandHandling\CommandBusInterface;
use Psr\Log\LoggerInterface;

class Handler
{

    public CommandBusInterface $commandBus;

    public function __construct(CommandBusInterface $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function handle(Command $command): void
    {
       dd($command,$this->commandBus);
    }
}