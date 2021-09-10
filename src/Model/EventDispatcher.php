<?php

declare(strict_types=1);

namespace Model;

interface EventDispatcher
{
    public function dispatch(array $events): void;
}
