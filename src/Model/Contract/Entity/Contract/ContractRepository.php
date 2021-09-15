<?php

declare(strict_types=1);

namespace App\Model\Contract\Entity\Contract;


use Doctrine\ORM\EntityManagerInterface;
use Infrastructure\Dispatchers\EventDispatcherInterface;
use App\Model\AggregateRoot;
use App\Model\EntityNotFoundException;
use App\Model\EventsTrait;

final class ContractRepository implements AggregateRoot
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
        $this->repo = $em->getRepository(Contract::class);
    }

    public function get(Id $id): Contract
    {
        /** @var Contract $advert */
        if (!$advert = $this->repo->find($id->getValue())) {
            throw new EntityNotFoundException('Contract is not found.');
        }
        return $advert;
    }

    public function getByAddress(string $address): Contract
    {
        /** @var Contract $advert */
        if (!$advert = $this->repo->findOneBy(['address' => $address])) {
            throw new EntityNotFoundException('Contract is not found.');
        }
        return $advert;
    }

    public function add(Contract $entity): void
    {
        $this->em->persist($entity);
        $this->em->flush();
        $this->eventDispatcher->dispatchAll($entity->releaseEvents());
    }
}
