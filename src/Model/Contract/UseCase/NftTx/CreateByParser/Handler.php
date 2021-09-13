<?php

declare(strict_types=1);

namespace App\Model\Contract\UseCase\NftTx\CreateByParser;

use App\Model\Contract\Entity\Contract\ContractRepository;
use App\Model\Contract\Entity\NftTx\Block;
use App\Model\Contract\Entity\NftTx\Gas;
use App\Model\Contract\Entity\NftTx\NftTx;
use App\Model\Contract\Entity\NftTx\NftTxRepository;
use App\Model\Contract\Entity\NftTx\Token;
use App\Model\Contract\Entity\NftTx\Transfer;
use Infrastructure\Http\Client\HttpClientInterface;
use Model\EntityNotFoundException;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;

class Handler
{

    public HttpClientInterface $httpClient;
    public ContractRepository $contractRepository;
    public NftTxRepository $nftTxRepository;
    public ContainerBagInterface $parameters;

    public function __construct(HttpClientInterface $httpClient,
                                ContractRepository $contractRepository,
                                NftTxRepository $nftTxRepository,
                                ContainerBagInterface $configurator)
    {
        $this->httpClient = $httpClient;
        $this->contractRepository = $contractRepository;
        $this->nftTxRepository = $nftTxRepository;
        $this->parameters = $configurator;
    }

    public function handle(Command $command): void
    {
        $contract = $this->contractRepository->getByAddress($this->parameters->get('ropsten.api.contract'));
        $escanApiUrl = $this->parameters->get('ropsten.api.url');
        $parameters = [
            'module'          => 'account',
            'action'          => 'tokennfttx',
            'contractaddress' => $this->parameters->get('ropsten.api.contract'),
            //'address'=>'0x92a26541e363c06fd20e65a3b6180b1319769512',
            'page'            => '1',
            'startblock'      => $this->nftTxRepository->getLastBlockNumber() + 1,
            'offset'          => '100',
            'sort'            => 'asc',
            'apikey'          => $this->parameters->get('ropsten.api.key'),
        ];
        $uri = $escanApiUrl . '?' . http_build_query($parameters);
        $response = json_decode($this->httpClient->get($uri)->getContents(), true);
        if ($response['status'] == '0') {//no transactions fount
            return;
        }
        if ($response['status'] != '1') {
            throw new \DomainException('Unable to parse nft transactions');
        }
        foreach ($response['result'] as $tx) {
            try {
                $txEntity = $this->nftTxRepository->getByHash($tx['hash']);
            } catch (EntityNotFoundException $e) {
                $nftTx = NftTx::createByParser(
                    $contract,
                    $tx['hash'],
                    (int)$tx['transactionIndex'],
                    (int)$tx['confirmations'],
                    (int)$tx['nonce'],
                    (int)$tx['timeStamp'],
                    new Token((int)$tx['tokenID'], $tx['tokenName'], $tx['tokenSymbol'], (int)$tx['tokenDecimal']),
                    new Block((int)$tx['blockNumber'], $tx['blockHash']),
                    new Transfer($tx['from'], $tx['to']),
                    new Gas((int)$tx['gas'], (int)$tx['gasPrice'], (int)$tx['gasUsed'], (int)$tx['cumulativeGasUsed'])
                );
                $this->nftTxRepository->add($nftTx);
            }
        }
    }
}