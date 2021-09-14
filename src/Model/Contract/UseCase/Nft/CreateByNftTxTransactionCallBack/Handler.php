<?php

declare(strict_types=1);

namespace App\Model\Contract\UseCase\Nft\CreateByNftTxTransactionCallBack;

use App\Model\Contract\Entity\Contract\ContractRepository;
use App\Model\Contract\Entity\Nft\Nft;
use App\Model\Contract\Entity\Nft\NftRepository;
use Infrastructure\Http\Client\HttpClientInterface;
use Infrastructure\Web3\Contract\Interactor\ERC721\Wbe3ContractInteractorFactory;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;

class Handler
{

    public HttpClientInterface $httpClient;
    public ContractRepository $contractRepository;
    public NftRepository $nftRepository;
    public ContainerBagInterface $parameters;

    public function __construct(ContractRepository $contractRepository,
                                NftRepository $nftRepository,
                                ContainerBagInterface $configurator)
    {
        $this->contractRepository = $contractRepository;
        $this->nftRepository = $nftRepository;
        $this->parameters = $configurator;
    }

    public function handle(Command $command): void
    {
        $contract = $this->contractRepository->get($command->contractId);
        $contractInteractor = (new Wbe3ContractInteractorFactory())->createERC721ContractInteractor($contract->getAddress(), $contract->getJsonAbi());
        $nftMeta = null;
        try {
            $nftIpfsUrl = $contractInteractor->tokenURI($command->tokenId);
            $nftMeta = json_decode(file_get_contents($nftIpfsUrl), true);
        } catch (\Throwable $throwable) {
            //do nothing, reparse later
        }
        $contractNft = Nft::CreateByNftTxTransactionCallBack($contract, $command->tokenId, $nftMeta);
        $this->nftRepository->add($contractNft);
    }
}