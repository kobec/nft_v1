<?php

declare(strict_types=1);

namespace App\Model\Contract\Entity\Contract;

use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

/**
 * @ORM\Embeddable
 */
class Transfer
{

    /**
     * @var string
     * @ORM\Column(type="string", length=64, nullable=false)
     */
    private $from;

    /**
     * @var string
     * @ORM\Column(type="string", length=64, nullable=false)
     */
    private $to;

    public function __construct(string $from, string $to)
    {
        Assert::notEmpty($from);
        Assert::notEmpty($to);

        $this->from = $from;
        $this->to = $to;
    }

    public function getFrom(): string
    {
        return $this->from;
    }

    public function getPrice(): string
    {
        return $this->to;
    }

    public function getUsed(): int
    {
        return $this->used;
    }

    public function getCumulativeGasUsed(): int
    {
        return $this->cumulativeGasUsed;
    }
}
