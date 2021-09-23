<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\User\Entity\User\Network;
use App\ReadModel\User\UserFetcher;
use Infrastructure\CommandHandling\CommandBusInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Ethereum\Ethereum;
use Ethereum\DataType\EthD;
use Exception;

class MetamaskController extends AbstractController
{
    private UserFetcher $userFetcher;
    private CommandBusInterface $commandBus;

    private const SIGN_MESSAGE = 'I am signing my one-time nonce: ';

    public function __construct(UserFetcher $userFetcher, CommandBusInterface $commandBus)
    {
        $this->userFetcher = $userFetcher;
        $this->commandBus = $commandBus;
    }

    /**
     * @Route("/api/v1/metamask/auth", methods="POST", name="metamask.auth")
     * @throws Exception
     */
    public function auth(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);

        $networkIdentity = $data['network_identity'] ?? null;
        $signature = $data['signature'] ?? null;

        // We are looking for a user at the networkIdentity if there is then we return networkIdentity, nonce
        if ($data = $this->userFetcher->getByNetworkIdentity(Network::NETWORK_CRYPTO_WALLET, $networkIdentity)) {
            $signMessage = self::SIGN_MESSAGE . $data->getNetworkNonce();

            // Verify digital signature
            $recoveredIdentity = Ethereum::personalEcRecover($signMessage, new EthD($signature));

            if ($success = ($recoveredIdentity && $networkIdentity && strtoupper($recoveredIdentity) === strtoupper($networkIdentity))) {
                // TODO: Implement user authentication

                return $this->json(compact('success'));
            }
        }

        return $this->json([], 400);
    }

    /**
     * @Route("/api/v1/metamask/signup", methods="POST", name="metamask.signup")
     * @throws Exception
     */
    public function signup(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);

        $networkIdentity = $data['network_identity'] ?? null;

        if ($networkIdentity) {
            // Create user and generate nonce. For each user in the database, generate a random string in the nonce field. For example, nonce can be a big random integer.
            $this->commandBus->dispatchNow(new \App\Model\User\UseCase\SignUp\ByMetamask\Command($networkIdentity));

            // We are looking for a user at the networkIdentity if there is then we return networkIdentity, nonce
            if ($data = $this->userFetcher->getByNetworkIdentity(Network::NETWORK_CRYPTO_WALLET, $networkIdentity)) {
                return $this->json($data->toArray());
            }
        }

        return $this->json([], 400);
    }

    /**
     * @Route("/api/v1/metamask/user/{networkIdentity}", methods="GET", name="metamask.user")
     */
    public function user(string $networkIdentity): JsonResponse
    {
        // We are looking for a user at the networkIdentity if there is then we return networkIdentity, nonce
        if ($data = $this->userFetcher->getByNetworkIdentity(Network::NETWORK_CRYPTO_WALLET, $networkIdentity)) {
            return $this->json($data->toArray());
        }

        return $this->json([], 404);
    }
}
