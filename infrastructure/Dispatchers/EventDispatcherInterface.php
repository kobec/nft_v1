<?php
/**
 * Created by PhpStorm.
 * User: yuko
 * Date: 05.09.19
 * Time: 15:31
 */
declare(strict_types=1);

namespace Infrastructure\Dispatchers;

/**
 * Interface EventDispatcherInterface
 * @package App\Services\Dispatchers
 */
interface EventDispatcherInterface
{
    public function dispatchAll(array $events): void;
    public function dispatch($event): void;
}
