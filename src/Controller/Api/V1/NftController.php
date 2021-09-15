<?php

namespace App\Controller\Api\V1;

use GuzzleHttp\Client;
use Infrastructure\CommandHandling\CommandBusInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Web3\Contract;

class NftController extends AbstractController
{

    /**
     * @Route("/api/v1/collected", name="nft.collected")
     */
    public function colleted(): JsonResponse
    {
        return new JsonResponse([
            ['name'=>'test1','image'=>'https://gateway.pinata.cloud/ipfs/QmU2r6tzXQFixoDEhSFwmtBpjvLavnoy7hBr5pTxrqmv6G'],
            ['name'=>'test2','image'=>'https://gateway.pinata.cloud/ipfs/QmU2r6tzXQFixoDEhSFwmtBpjvLavnoy7hBr5pTxrqmv6G'],
        ]);
    }
}
