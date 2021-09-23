<?php

declare(strict_types=1);

namespace App\ReadModel\User;

use App\Model\User\Entity\User\User;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use App\ReadModel\User\Presenters\UserNetworkIdentityPresenter;
use Doctrine\ORM\NonUniqueResultException;

class UserFetcher
{
    private Connection $connection;
    private EntityRepository $repository;

    public function __construct(Connection $connection, EntityManagerInterface $em)
    {
        $this->connection = $connection;
        $this->repository = $em->getRepository(User::class);
    }

    /**
     * @throws NonUniqueResultException
     */
    public function getByNetworkIdentity(string $network, string $identity): ?UserNetworkIdentityPresenter
    {
        $query = $this->repository->createQueryBuilder('t')
            ->select('t', 'n')
            ->innerJoin('t.networks', 'n')
            ->where('n.network = :network and n.identity = :identity')
            ->setParameter(':network', $network)
            ->setParameter(':identity', $identity)
            ->getQuery();

        /** @var User $user */
        if ($user = $query->getOneOrNullResult()) {
            $network = $user->getFirstNetwork();

            return new UserNetworkIdentityPresenter(
                (string) $user->getId(),
                $network->getNetwork(),
                $network->getIdentity(),
                $network->getBlockChainAuthNonce(),
            );
        }

        return null;
    }

    private function createQb(): QueryBuilder
    {
        return $this->connection->createQueryBuilder();
    }
}
