<?php

declare(strict_types=1);

namespace App\Model\User\UseCase\Network\RefreshBlockChainAuthNonce;

use App\Model\Flusher;
use App\Model\User\Entity\User\UserRepository;

class Handler
{
    private UserRepository $userRepository;
    private Flusher $flusher;

    public function __construct(UserRepository $userRepository, Flusher $flusher)
    {
        $this->userRepository = $userRepository;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $user = $this->userRepository->getByNetworkIdentity($command->network, $command->identity);

        $network = $user->getFirstNetwork();

        $network->refreshBlockChainAuthNonce();

        $this->flusher->flush();
    }
}
