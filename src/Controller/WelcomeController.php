<?php

namespace App\Controller;

use App\Model\User\Service\NonceGenerator;
use GuzzleHttp\Client;
use Infrastructure\CommandHandling\CommandBusInterface;
use Infrastructure\CommandHandling\SymfonyCommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Web3\Contract;

class WelcomeController extends AbstractController
{

    /**
     * @Route("/welcome", name="welcome")
     */
    public function index(CommandBusInterface $commandBus): Response
    {
        $cmd=new \App\Model\Contract\UseCase\NftTx\CreateByParser\Command();
        $commandBus->dispatch($cmd);
        dd('1');
        $contractAddress='0xfaCf2DeE4197560D74E26C1158D17152b5384F2e';
        $abi=file_get_contents('contract-abi.json');
        $contract = new Contract('https://eth-ropsten.alchemyapi.io/v2/nnPnXXYn1e2Jb1wymxwennbIZ6RLQJP6', $abi);

        $c=$contract->at($contractAddress)->call('tokenURI',1,function ($data){
         //   print_r($data);
        });
        dd($c);

        $cmd=new \App\Model\Contract\UseCase\NftTx\CreateByParser\Command();
        $commandBus->dispatch($cmd);
        dd('333');
        //etherscan api key FKQFUP47GG13YNJ7MHFZP5NWKP2T3Y2WKU
        $escanApiUrl='https://api-ropsten.etherscan.io/api';
        $parameters=[
            'module'=>'account',
            'action'=>'tokennfttx',
            'contractaddress'=>'0xfaCf2DeE4197560D74E26C1158D17152b5384F2e',
           //'address'=>'0x92a26541e363c06fd20e65a3b6180b1319769512',
            'page'=>'1',
            'offset'=>'100',
            'sort'=>'asc',
            'apikey'=>'FKQFUP47GG13YNJ7MHFZP5NWKP2T3Y2WKU',
        ];
        $query=$escanApiUrl.'?'.http_build_query($parameters);
        $guzzle= new Client();
        $response=$guzzle->get($query);
        $json=json_decode($response->getBody()->getContents(),true);
        dd($json);
        $apiUrl='https://eth-mainnet.alchemyapi.io/v2/w_RgZ-0oXmoZkZbyoZkLEF-CtJp457vD';
        $guzzle= new Client();
        $data=$guzzle->request('GET', 'https://etherscan.io/address/0x88a9780Fb8077c40CF02402a8eea829abE63F286');
        dd($data->getBody()->getContents());
        $json=[
          'jsonrpc'=>'2.0',
          'id'=>'3',
          'method'=>'alchemy_getAssetTransfers',
          'params'=>[
              'contractAddresses'=>['0x7fc66500c84a76ad7e9c93437bfc5ac33e2ddae9']
          ]
        ];
        $data=$guzzle->request('POST', $apiUrl,['json'=>$json]);
        dd($data->getBody()->getContents());
        return $this->render('welcome/index.html.twig', [
            'controller_name' => 'WelcomeController',
        ]);
    }
}
