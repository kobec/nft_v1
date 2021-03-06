<?php

declare(strict_types=1);

namespace App\Model\Contract\Entity\NftTx;

use App\Model\Contract\Entity\Contract\Contract;
use App\Model\Contract\Entity\NftTx\Event\NftTxCreatedEvent;
use Doctrine\ORM\Mapping as ORM;
use App\Model\AggregateRoot;
use App\Model\DatesColumnsTrait;
use App\Model\EventsTrait;
use Ramsey\Uuid\Uuid;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="contract_nft_txs", uniqueConstraints={
 *     @ORM\UniqueConstraint(columns={"hash"})
 * })
 */
class NftTx implements AggregateRoot
{

    use EventsTrait;

    /**
     * @ORM\Column(type="contract_nft_tx_id")
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
     * @var string
     * @ORM\Column(type="string", length=128, nullable=false)
     */
    private $hash;

    /**
     * @var int
     * @ORM\Column(type="integer", nullable=false)
     */
    private $transactionIndex;

    /**
     * @var int
     * @ORM\Column(type="integer", nullable=false)
     */
    private $confirmations;

    /**
     * @var int
     * @ORM\Column(type="integer", nullable=false)
     */
    private $nonce;

    /**
     * @var $timeStamp
     * @ORM\Column(type="integer", nullable=false)
     */
    private $timeStamp;

    /**
     * @var Block
     * @ORM\Embedded(class="Block")
     */
    private $block;

    /**
     * @var Transfer
     * @ORM\Embedded(class="Transfer")
     */
    private $transfer;

    /**
     * @var Token
     * @ORM\Embedded(class="Token")
     */
    private $token;

    /**
     * @var Gas
     * @ORM\Embedded(class="Gas")
     */
    private $gas;

    use DatesColumnsTrait;


    private function __construct(Contract $contract,
                                 string $hash,
                                 int $transactionIndex,
                                 int $confirmations,
                                 int $nonce,
                                 int $timestamp,
                                 Token $token,
                                 Block $block,
                                 Transfer $transfer,
                                 Gas $gas
    )
    {
        $id = Id::next();
        $this->id = $id;
        $this->contract = $contract;
        $this->hash = $hash;
        $this->transactionIndex = $transactionIndex;
        $this->confirmations = $confirmations;
        $this->nonce = $nonce;
        $this->timeStamp = $timestamp;
        $this->token = $token;
        $this->block = $block;
        $this->transfer = $transfer;
        $this->gas = $gas;
        $this->recordEvent(new NftTxCreatedEvent($this));
    }

    public static function createByParser(Contract $contract,
                                          string $hash,
                                          int $transactionIndex,
                                          int $confirmations,
                                          int $nonce,
                                          int $timestamp,
                                          Token $token,
                                          Block $block,
                                          Transfer $transfer,
                                          Gas $gas): self
    {
        return new self($contract, $hash, $transactionIndex, $confirmations, $nonce, $timestamp, $token, $block, $transfer, $gas);
    }

    public function getBlockNumber(): int
    {
        return $this->block->getNumber();
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function getContractId(): \App\Model\Contract\Entity\Contract\Id
    {
        return $this->contract->getId();
    }

    public function getToken(): Token
    {
        return $this->token;
    }
}
