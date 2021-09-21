<?php

declare(strict_types=1);

namespace App\Model\User\Service;

use Ramsey\Uuid\Uuid;
use Webmozart\Assert\Assert;

class NonceGenerator
{
    private $value;

    public function __construct(string $value)
    {
        Assert::notEmpty($value);
        $this->value = $value;
    }

    public static function next(): self
    {
        return new self(bin2hex(random_bytes(16)));
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->getValue();
    }
}
