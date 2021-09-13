<?php

declare(strict_types=1);

namespace App\Model\Contract\Entity\NftTx;

use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

/**
 * @ORM\Embeddable
 */
class Block
{
    /**
     * @var int
     * @ORM\Column(type="bigint", nullable=false)
     */
    private $number;

    /**
     * @var string
     * @ORM\Column(type="string", length=128, nullable=false)
     */
    private $hash;

    public function __construct(int $number, string $hash)
    {
        Assert::notEmpty($number);
        Assert::notEmpty($hash);

        $this->number = $number;
        $this->hash = $hash;
    }

    public function getNumber(): int
    {
        return $this->number;
    }

    public function getHash(): string
    {
        return $this->hash;
    }
}
