<?php

declare(strict_types=1);

namespace App\Model\Contract\Entity\NftTx;


use Doctrine\ORM\EntityManagerInterface;
use Infrastructure\Dispatchers\EventDispatcherInterface;
use Model\AggregateRoot;
use Model\EntityNotFoundException;
use Model\EventsTrait;

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
                                EventDispatcherInterface $eventDispatcher)
    {
        $this->em = $em;
        $this->eventDispatcher = $eventDispatcher;
        $this->repo = $em->getRepository(NftTx::class);
    }

    public function getByHash(string $hash): self
    {
        /** @var self $nftTx */
        if (!$nftTx = $this->repo->findOneBy(['hash' => $hash])) {
            throw new EntityNotFoundException('Nft transaction is not found.');
        }
        return $nftTx;
    }

    public function add(NftTx $entity): void
    {
        $this->em->persist($entity);
        $this->em->flush();
        $this->eventDispatcher->dispatchAll($entity->releaseEvents());
    }
}
