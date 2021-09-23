<?php

declare(strict_types=1);

namespace App\Model\User\Entity\User;

use App\Model\User\Service\NonceGenerator;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Webmozart\Assert\Assert;
use Exception;

/**
 * @ORM\Entity
 * @ORM\Table(name="user_user_networks", uniqueConstraints={
 *     @ORM\UniqueConstraint(columns={"network", "identity"})
 * })
 */
class Network
{
    /**
     * @var string
     * @ORM\Column(type="guid")
     * @ORM\Id
     */
    private $id;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User", inversedBy="networks")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    private $user;

    /**
     * @var string
     * @ORM\Column(type="string", length=32, nullable=true)
     */
    private $network;

    /**
     * @var array
     * @ORM\Column(type="json", nullable=true)
     */
    private $data;

    /**
     * @var string
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    private $identity;

    public const NETWORK_CRYPTO_WALLET = 'crypto_wallet';

    public static $allowed_networks = [
        self::NETWORK_CRYPTO_WALLET
    ];

    public function __construct(User $user, string $network, string $identity)
    {
        Assert::oneOf($network, self::$allowed_networks);
        $this->id = Uuid::uuid4()->toString();
        $this->user = $user;
        $this->network = $network;
        $this->identity = $identity;
    }


    /**
     * @throws Exception
     */
    public static function createCryptoWalletNetwork(User $user, string $identity): Network
    {
        $entity = new self($user, self::NETWORK_CRYPTO_WALLET, $identity);
        $entity->generateBlockChainAuthNonce();
        return $entity;
    }

    /**
     * @throws Exception
     */
    private function generateBlockChainAuthNonce(): void
    {
        $this->data = $this->data ?? [];

        $this->data['nonce'] = (string) NonceGenerator::next();
    }

    /**
     * @throws Exception
     */
    public function refreshBlockChainAuthNonce(): void
    {
        $this->generateBlockChainAuthNonce();
    }

    public function getBlockChainAuthNonce(): ?string
    {
        return $this->data['nonce'] ?? null;
    }

    public function isFor(string $network, string $identity): bool
    {
        return $this->network === $network && $this->identity === $identity;
    }

    public function isForNetwork(string $network): bool
    {
        return $this->network === $network;
    }

    public function getNetwork(): string
    {
        return $this->network;
    }

    public function getIdentity(): string
    {
        return $this->identity;
    }
}
