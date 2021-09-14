<?php
declare(strict_types=1);

namespace App\Model\Contract\Entity\NftTx\Event;

use App\Model\Contract\Entity\NftTx\NftTx;

class NftTxCreatedEvent
{

    private NftTx $nftTx;

    public function __construct(NftTx $nftTx)
    {
        $this->nftTx = $nftTx;
    }

    public function getContractId()
    {
        return $this->nftTx->getContractId();
    }

    public function getContractTokenId()
    {
        return $this->nftTx->getToken()->getId();
    }
}