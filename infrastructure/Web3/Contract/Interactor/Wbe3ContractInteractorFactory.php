<?php

declare(strict_types=1);

namespace Infrastructure\Web3\Contract\Interactor\ERC721;


class Wbe3ContractInteractorFactory
{
    public function createERC721ContractInteractor(string $contract, string $jsonAbi): ERC721ContractInteractorInterface
    {
        return new Sc0vuERC721ContractInteractorInterface($contract, $jsonAbi);
    }
}