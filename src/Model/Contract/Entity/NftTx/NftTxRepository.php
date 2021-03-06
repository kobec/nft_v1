<?php

declare(strict_types=1);

namespace App\Model\Contract\Entity\NftTx;


use Doctrine\ORM\EntityManagerInterface;
use Infrastructure\Dispatchers\EventDispatcherInterface;
use App\Model\AggregateRoot;
use App\Model\EntityNotFoundException;
use App\Model\EventsTrait;

final class NftTxRepository implements AggregateRoot
{
    use EventsTrait;

    private EntityManagerInterface $em;
    private EventDispatcherInterface $eventDispatcher;
    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    private $repo;

    public function __construct(EntityManagerInterface $em,
                                EventDispatcherInterface $eventDispatcher
    )
    {
        $this->em = $em;
        $this->eventDispatcher = $eventDispatcher;
        $this->repo = $em->getRepository(NftTx::class);
    }

    public function getByHash(string $hash): NftTx
    {
        /** @var NftTx $nftTx */
        if (!$nftTx = $this->repo->findOneBy(['hash' => $hash])) {
            throw new EntityNotFoundException('Nft transaction is not found.');
        }
        return $nftTx;
    }

    public function getLastBlockNumber(): int
    {
        /** @var NftTx $nftTx */
        if (!$nftTx = $this->repo->findOneBy([], ['block.number' => 'DESC'])) {
            return 0;
        }
        return $nftTx->getBlockNumber();
    }

    public function add(NftTx $entity): void
    {
        $this->em->persist($entity);
        $this->em->flush();
        $this->eventDispatcher->dispatchAll($entity->releaseEvents());
    }
}
