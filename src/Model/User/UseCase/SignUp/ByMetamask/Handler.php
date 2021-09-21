<?php

declare(strict_types=1);

namespace App\Model\User\UseCase\SignUp\ByMetamask;

use App\Model\Flusher;
use App\Model\User\Entity\User\Network;
use App\Model\User\Entity\User\User;
use App\Model\User\Entity\User\UserRepository;
use App\Model\User\Service\PasswordGenerator;
use App\Model\User\Service\PasswordHasher;

class Handler
{
    private $users;
    private $hasher;
    private $generator;
    private $flusher;

    public function __construct(
        UserRepository $users,
        PasswordHasher $hasher,
        PasswordGenerator $generator,
        Flusher $flusher
    )
    {
        $this->users = $users;
        $this->hasher = $hasher;
        $this->generator = $generator;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {

        if ($this->users->hasByNetworkIdentity(Network::NETWORK_CRYPTO_WALLET, $command->wallet)) {
            throw new \DomainException('Profile is already in use.');
        }


        $user = User::signUpByMetamask(

        );

        $this->users->add($user);

        $this->flusher->flush();
    }
}
