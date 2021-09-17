<?php

declare(strict_types=1);

namespace App\ReadModel\Contract\Nft;

use App\Model\Contract\Entity\Nft\Nft;
use App\ReadModel\NotFoundException;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

class NftFetcher
{
    private $connection;
    private $paginator;
    private $repository;

    public function __construct(Connection $connection, EntityManagerInterface $em, PaginatorInterface $paginator)
    {
        $this->connection = $connection;
        $this->repository = $em->getRepository(Nft::class);
        $this->paginator = $paginator;
    }


    public function paginatedForContract(string $contract, int $page, int $size): PaginationInterface
    {
        $qb = $this->createQb()
            ->select(
                'contract.address as contract_address,nft.id as nft_id,nft.token_id as token_id,nft.data as token_data'
            )
            ->from('contract_nft', 'nft')
            ->leftJoin('nft', 'contract_contracts', 'contract', 'nft.contract_id = contract.id')
            ->where('contract.address=:contract_address')
            ->setParameter('contract_address', $contract);
        return $this->paginator->paginate($qb, $page, $size);
    }


    public function getByContractAddressAndTokenId(string $contract, int $tokenId): \App\ReadModel\Contract\Nft\Presenters\Nft
    {
        $qb = $this->createQb()
            ->select(
                'contract.address as contract_address,nft.id as nft_id,nft.token_id as token_id,nft.data as token_data'
            )
            ->from('contract_nft', 'nft')
            ->leftJoin('nft', 'contract_contracts', 'contract', 'nft.contract_id = contract.id')
            ->where('contract.address=:contract_address')
            ->setParameter('contract_address', $contract)
            ->where('nft.token_id=:token_id')
            ->setParameter('token_id', $tokenId)
            ->execute();
        if (!$token = $qb->fetchAssociative()) {
            throw new NotFoundException('Token is not found is not found');
        }
        return new \App\ReadModel\Contract\Nft\Presenters\Nft($token['nft_id'],$contract,(int)$token['token_id'],json_decode($token['token_data'], true));
    }

    private function createQb(): QueryBuilder
    {
        return $this->connection->createQueryBuilder();

    }
}
