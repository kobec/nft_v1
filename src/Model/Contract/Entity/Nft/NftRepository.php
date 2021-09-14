<?php

declare(strict_types=1);

namespace App\Model\Contract\Entity\Nft;


use Doctrine\ORM\EntityManagerInterface;
use Infrastructure\Dispatchers\EventDispatcherInterface;
use Model\AggregateRoot;
use Model\EntityNotFoundException;
use Model\EventsTrait;

final class NftRepository implements AggregateRoot
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
                              //  EventDispatcher $eventDispatcher
    )
    {
        $this->em = $em;
        $this->eventDispatcher = $eventDispatcher;
        $this->repo = $em->getRepository(Nft::class);
    }

    public function getByContractIdAndTokenId(\App\Model\Contract\Entity\Contract\Id $contractId, int $tokenId): Nft
    {
        /** @var Nft $entity */
        if (!$entity = $this->repo->findOneBy(['contract' => $contractId,'tokenId'=>$tokenId])) {
            throw new EntityNotFoundException('Contract Nft is not found.');
        }
        return $entity;
    }

    public function add(Nft $entity): void
    {
        $this->em->persist($entity);
        $this->em->flush();
        $this->eventDispatcher->dispatchAll($entity->releaseEvents());
    }
}
