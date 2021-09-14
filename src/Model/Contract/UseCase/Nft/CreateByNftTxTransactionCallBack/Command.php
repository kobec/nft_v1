<?php

declare(strict_types=1);

namespace App\Model\Contract\UseCase\Nft\CreateByNftTxTransactionCallBack;


use App\Model\Contract\Entity\Contract\Id;

class Command
{
    public Id $contractId;
    public int $tokenId;

    public function __construct(Id $contractId, $tokenId)
    {
        $this->contractId = $contractId;
        $this->tokenId = $tokenId;
    }
}