<?php

declare(strict_types=1);

namespace App\Model\Contract\Entity\Contract;

use Webmozart\Assert\Assert;

class Standard
{
    public const STANDARD_ERC721 = 'ERC721';
    public const STANDARD_ERC1155 = 'ERC1155';

    private string $name;

    public function __construct(string $name)
    {
        Assert::oneOf($name, [
            self::STANDARD_ERC721,
            self::STANDARD_ERC1155
        ]);

        $this->name = $name;
    }

    public static function erc721(): self
    {
        return new self(self::STANDARD_ERC721);
    }

    public static function erc1155(): self
    {
        return new self(self::STANDARD_ERC1155);
    }

    public function isEqual(self $standard): bool
    {
        return $this->getName() === $standard->getName();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getValue():string
    {
        return $this->getName();
    }
}
