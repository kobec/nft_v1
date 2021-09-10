<?php


namespace Infrastructure\CommandHandling;


interface CommandBusInterface
{
    /**
     * Dispatches the command $command to the proper CommandHandler without queue.
     *
     * @param mixed $command
     */
    public function dispatchNow($command);
    /**
     * Dispatches the command $command to the proper CommandHandler.
     *
     * @param mixed $command
     */
    public function dispatch($command): void;
    /**
     * Dispatches the command $command to the proper CommandHandler by queue.
     *
     * @param mixed $command
     */
    public function dispatchToQueue($command): void;
    /**
     * Subscribes the command and command handler to this CommandBus.
     * @param string $commandClass
     * @param string $handlerClass
     */
    public function subscribe(string $commandClass, string $handlerClass): void;
}