<?php

declare(strict_types=1);

namespace App\Model\Contract\Entity\Contract;

use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

/**
 * @ORM\Embeddable
 */
class Gas
{

    /**
     * @var int
     * @ORM\Column(type="integer", nullable=false)
     */
    private $gas;

    /**
     * @var int
     * @ORM\Column(type="integer", nullable=false)
     */
    private $price;

    /**
     * @var int
     * @ORM\Column(type="integer", nullable=false)
     */
    private $used;

    /**
     * @var int
     * @ORM\Column(type="integer", nullable=false)
     */
    private $cumulativeGasUsed;

    public function __construct(int $gas, int $price, int $used, int $cumulativeGasUsed)
    {
        Assert::notEmpty($gas);
        Assert::notEmpty($price);
        Assert::notEmpty($used);
        Assert::notEmpty($cumulativeGasUsed);

        $this->gas = $gas;
        $this->price = $price;
        $this->used = $used;
        $this->cumulativeGasUsed = $cumulativeGasUsed;
    }

    public function getGas(): int
    {
        return $this->gas;
    }

    public function getPrice(): int
    {
        return $this->price;
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
