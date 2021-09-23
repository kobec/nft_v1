<?php

declare(strict_types=1);

namespace App\ReadModel\User\Presenters;

class UserNetworkIdentityPresenter
{
    public string $userId;
    public string $networkName;
    public string $networkIdentity;
    public string $networkNonce;

    public function __construct(string $userId, string $networkName, string $networkIdentity, string $networkNonce)
    {
        $this->userId = $userId;
        $this->networkName = $networkName;
        $this->networkIdentity = $networkIdentity;
        $this->networkNonce = $networkNonce;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function getNetworkName(): string
    {
        return $this->networkName;
    }

    public function getNetworkIdentity(): string
    {
        return $this->networkIdentity;
    }

    public function getNetworkNonce(): string
    {
        return $this->networkNonce;
    }

    public function toArray(): array
    {
        return [
            'user_id' => $this->getUserId(),
            'network_name' => $this->getNetworkName(),
            'network_identity' => $this->getNetworkIdentity(),
            'network_nonce' => $this->getNetworkNonce(),
        ];
    }
}
