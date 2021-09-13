<?php

declare(strict_types=1);

namespace App\Model\Contract\Entity\Contract;

use App\Model\Contract\Entity\NftTx\NftTx;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Model\AggregateRoot;
use Model\DatesColumnsTrait;
use Model\EventsTrait;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="contract_contracts", uniqueConstraints={
 *     @ORM\UniqueConstraint(columns={"address"})
 * })
 */
class Contract implements AggregateRoot
{

    use EventsTrait;
    /**
     * @ORM\Column(type="contract_contract_id")
     * @ORM\Id
     */
    private $id;

    /**
     * @var string|null
     * @ORM\Column(type="string", name="address", nullable=true)
     */
    private $address;

    /**
     * @var Standard|null
     * @ORM\Column(type="contract_contract_standard", nullable=true)
     */
    private $standard;

    /**
     * @ORM\Version()
     * @ORM\Column(type="integer")
     */
    private $version;

    use DatesColumnsTrait;

    /**
     * @var NftTx[]|ArrayCollection
     * @ORM\OneToMany(targetEntity="App\Model\Contract\Entity\NftTx\NftTx", mappedBy="contract", orphanRemoval=true, cascade={"persist"})
     */
    private $nftTxs;

    private function __construct(Id $id, string $address, Standard $standard)
    {
        $this->id = $id;
        $this->address = $address;
        $this->standard = $standard;
        $this->nftTxs = new ArrayCollection();
    }

    public function addNftTx(NftTx $nftTx): void
    {
        $this->nftTxs->add($nftTx);
    }

    public static function create(Id $id, string $address, Standard $standard): self
    {
        $entity = new self($id, $address, $standard);
        return $entity;
    }


    public function getId(): Id
    {
        return $this->id;
    }

    public function getStandard(): ?Standard
    {
        return $this->standard;
    }
}
