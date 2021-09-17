<?php

namespace App\Controller\Api\V1;

use App\Controller\Api\PaginationSerializer;
use App\ReadModel\Contract\ContractFetcher;
use App\ReadModel\Contract\Nft\NftFetcher;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class NftController extends AbstractController
{

    private const PER_PAGE = 3;
    private NftFetcher $nftFetcher;
    private ContainerBagInterface $parameters;

    public function __construct(NftFetcher $nftFetcher,
                                ContainerBagInterface $configurator)
    {
        $this->nftFetcher = $nftFetcher;
        $this->parameters = $configurator;
    }

    /**
     * @Route("/api/v1/collected", name="nft.collected")
     */
    public function colleted(Request $request): JsonResponse
    {
        $contract = $this->parameters->get('ropsten.api.contract');
        $pagination = $this->nftFetcher->paginatedForContract(
            $contract,
            $request->query->getInt('page', 1),
            self::PER_PAGE
        );

        return $this->json([
            'items'      => array_map(static function (array $item) {
                return [
                    'id'               => $item['nft_id'],
                    'contract_address' => $item['contract_address'],
                    'token_id'         => $item['token_id'],
                    'token_data'       => json_decode($item['token_data'], true),
                ];
            }, (array)$pagination->getItems()),
            'pagination' => PaginationSerializer::toArray($pagination),
        ]);
    }

    /**
     * @Route("/api/v1/assets/{contractAddress}/{tokenId}", name="nft.item")
     */
    public function nft(string $contractAddress, int $tokenId){
        try {
            $nft=$this->nftFetcher->getByContractAddressAndTokenId($contractAddress,$tokenId);
            return $this->json($nft->toArray());
        }catch (\Throwable $throwable){
            return $this->json($throwable->getMessage(),$throwable->getCode());
        }
    }
}
