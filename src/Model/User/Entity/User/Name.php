<?php

declare(strict_types=1);

namespace App\Model\User\Entity\User;

use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

/**
 * @ORM\Embeddable
 */
class Name
{
    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $first;
    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $last;

    public function __construct(?string $first, ?string $last)
    {
        $this->first = $first;
        $this->last = $last;
    }

    public function getFirst(): string
    {
        return $this->first ?? '';
    }

    public function getLast(): string
    {
        return $this->last ?? '';
    }

    public function getFull(): string
    {
        return trim($this->first . ' ' . $this->last);
    }
}
