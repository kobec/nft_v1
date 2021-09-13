<?php

declare(strict_types=1);

namespace App\Model\Contract\Entity\NftTx;

use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

/**
 * @ORM\Embeddable
 */
class Token
{

    /**
     * @var int
     * @ORM\Column(type="integer", nullable=false)
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=48, nullable=false)
     */
    private $name;

    /**
     * @var string
     * @ORM\Column(type="string", length=12, nullable=false)
     */
    private $symbol;

    /**
     * @var string
     * @ORM\Column(type="decimal")
     */
    private $decimal;

    public function __construct(int $id, string $name, string $symbol, int $decimal)
    {
        Assert::integer($id);
        Assert::notEmpty($name);
        Assert::notEmpty($symbol);
        Assert::integer($decimal);

        $this->id = $id;
        $this->name = $name;
        $this->symbol = $symbol;
        $this->decimal = $decimal;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSymbol(): string
    {
        return $this->symbol;
    }

    public function getDecimal(): int
    {
        return $this->decimal;
    }

    public function getFull(): string
    {
        return $this->name . ' ' . $this->symbol;
    }
}
