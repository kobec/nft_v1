<?php

declare(strict_types=1);

namespace App\Model\Contract\Entity\Nft;

use App\Model\Contract\Entity\Contract\Contract;
use App\Model\Contract\Entity\NftTx\Block;
use App\Model\Contract\Entity\NftTx\Gas;
use App\Model\Contract\Entity\NftTx\Token;
use App\Model\Contract\Entity\NftTx\Transfer;
use Doctrine\ORM\Mapping as ORM;
use Model\AggregateRoot;
use Model\DatesColumnsTrait;
use Model\EventsTrait;
use Ramsey\Uuid\Uuid;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="contract_nft", uniqueConstraints={
 *     @ORM\UniqueConstraint(columns={"contract_id","token_id"})
 * })
 */
class Nft implements AggregateRoot
{

    use EventsTrait;

    /**
     * @ORM\Column(type="contract_nft_id")
     * @ORM\Id
     */
    private $id;

    /**
     * @var Contract
     * @ORM\ManyToOne(targetEntity="App\Model\Contract\Entity\Contract\Contract", inversedBy="nft_txs")
     * @ORM\JoinColumn(name="contract_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    private $contract;

    /**
     * @var int
     * @ORM\Column(type="integer", nullable=false)
     */
    private $tokenId;

    /**
     * @var string
     * @ORM\Column(type="json", nullable=true)
     */
    private $data;


    use DatesColumnsTrait;


    private function __construct(Contract $contract,
                                 int $tokenId,
                                 array $data = null
    )
    {
        $this->id = Id::next();
        $this->contract = $contract;
        $this->tokenId = $tokenId;
        $this->data = $data;
    }

    public static function CreateByNftTxTransactionCallBack(Contract $contract,
                                                            int $tokenId,
                                                            array $data = null): self
    {
        return new self($contract, $tokenId, $data);
    }
}
