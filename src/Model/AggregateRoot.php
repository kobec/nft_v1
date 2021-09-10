<?php

declare(strict_types=1);

namespace Model;

interface AggregateRoot
{
    public function releaseEvents(): array;
}
