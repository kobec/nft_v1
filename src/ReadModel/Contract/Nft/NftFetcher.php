<?php

declare(strict_types=1);

namespace App\ReadModel\Contract\Nft;

use App\Model\User\Entity\User\User;
use App\ReadModel\NotFoundException;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\FetchMode;
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
        $this->repository = $em->getRepository(User::class);
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

    private function createQb(): QueryBuilder
    {
        return $this->connection->createQueryBuilder();

    }
}
