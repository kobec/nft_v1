<?php

declare(strict_types=1);

namespace Infrastructure\Web3\Contract\Interactor\ERC721;

/**
 * Interface to interact with existing contract functionality
 * Interface ERC721ContractInteractorInterface
 * @package Infrastructure\Web3\Contract\ERC721
 */
interface ERC721ContractInteractorInterface
{
    public function tokenURI(int $tokenId): string;
}