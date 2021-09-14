<?php

declare(strict_types=1);

namespace Infrastructure\Web3\Contract\Interactor\ERC721;

use Web3\Contract;

/**
 * Sc0vu realisation of ERC721ContractInteractorInterface to interact with existing contract functionality
 * Interface ERC721ContractInteractorInterface
 * @package Infrastructure\Web3\Contract\ERC721
 */
class Sc0vuERC721ContractInteractorInterface implements ERC721ContractInteractorInterface
{
    private string $contract;
    private string $jsonAbi;

    public function __construct(string $contract, string $jsonAbi)
    {
        $this->contract = $contract;
        $this->jsonAbi = $jsonAbi;
    }

    public function tokenURI(int $tokenId): string
    {
        $contract = new Contract('https://eth-ropsten.alchemyapi.io/v2/nnPnXXYn1e2Jb1wymxwennbIZ6RLQJP6', $this->jsonAbi);
        $ipfsUrl = null;
        $contract->at($this->contract)->call('tokenURI', $tokenId, function ($data, $result) use (&$ipfsUrl) {
            $ipfsUrl = $result[0];
        });
        return $ipfsUrl;
    }
}