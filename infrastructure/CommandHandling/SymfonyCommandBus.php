<?php


namespace Infrastructure\CommandHandling;

use Psr\Container\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Contracts\Service\ServiceSubscriberInterface;


class SymfonyCommandBus implements CommandBusInterface, ServiceSubscriberInterface
{
    private $commandHandlers = [];
    private $queue = [];
    private $isDispatching = false;
    private $dispatcher;
    private $container;
    private $locator;

    public function __construct(ContainerInterface $container)
    {
        $this->locator = $container;
    }

    public static function getSubscribedServices(): array
    {
        return [
            \App\Model\Contract\UseCase\NftTx\CreateByParser\Command::class                 => \App\Model\Contract\UseCase\NftTx\CreateByParser\Handler::class,
            \App\Model\Contract\UseCase\Nft\CreateByNftTxTransactionCallBack\Command::class => \App\Model\Contract\UseCase\Nft\CreateByNftTxTransactionCallBack\Handler::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function subscribe(string $commandClass, string $handlerClass): void
    {
        $this->commandHandlers[$commandClass] = $handlerClass;
    }

    public function dispatchNow($command)
    {
        $commandClass = get_class($command);

        if ($this->locator->has($commandClass)) {
            $handler = $this->locator->get($commandClass);
            return $handler->handle($command);
        }
        throw new CommandBusException('no handlers registered to this Command');
    }

    public function dispatchNow2($command)
    {
        $commandClass = get_class($command);
        /*  $handlerClass = str_replace('\Command', '\Handler', $commandClass);
          dd('dd');*/

        if (array_key_exists($commandClass, $this->commandHandlers)) {
            $handler = $this->container->get($this->commandHandlers[$commandClass]);
            return $handler->handle($command);
        }
        try {
            //try by namespace
            $handlerClass = str_replace('\Command', '\Handler', $commandClass);
            // $h=new $handlerClass;
            // dd($h);
            $containerBuilder = new ContainerBuilder();
            $containerBuilder->register($handlerClass, $handlerClass)->setPublic(true);
            // $containerBuilder->resolveServices($handlerClass);
            // // $containerBuilder->registerForAutoconfiguration($handlerClass);
            $containerBuilder->compile();
            $handler = $containerBuilder->get($handlerClass);
            return $handler->handle($command);
        } catch (\Throwable $throwable) {
            dd($throwable);
            throw new CommandBusException('no handlers registered to this Command');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function dispatch($command): void
    {
        $this->dispatchNow($command);
        /* if (property_exists($command, 'byQueue') && $command->byQueue === true) {
             $this->dispatchToQueue($command);
         } else {
             $this->dispatcher->dispatch($this->getJob($command));
         }*/
    }

    public function dispatchToQueue($command): void
    {
        $this->dispatchNow($command);
        //$this->dispatcher->dispatchToQueue($this->getJob($command));
    }
}