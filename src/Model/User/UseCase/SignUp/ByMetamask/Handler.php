<?php

declare(strict_types=1);

namespace App\Model\User\UseCase\SignUp\ByMetamask;

use App\Model\Flusher;
use App\Model\User\Entity\User\Network;
use App\Model\User\Entity\User\User;
use App\Model\User\Entity\User\UserRepository;
use App\Model\User\Entity\User\Id;
use DateTimeImmutable;

class Handler
{
    private UserRepository $users;
    private Flusher $flusher;

    public function __construct(
        UserRepository $users,
        Flusher $flusher
    ) {
        $this->users = $users;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        if ($this->users->hasByNetworkIdentity(Network::NETWORK_CRYPTO_WALLET, $command->wallet)) {
            throw new \DomainException('Profile is already in use.');
        }

        $user = User::signUpByMetamask(Id::next(), new DateTimeImmutable(), $command->wallet);

        $this->users->add($user);

        $this->flusher->flush();
    }
}
