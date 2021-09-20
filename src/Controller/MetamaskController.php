<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Ethereum\Ethereum;
use Ethereum\DataType\EthD;
use \JsonException;
use \Exception;

class MetamaskController extends AbstractController
{
    /**
     * @Route("/api/v1/metamask/auth", methods="POST", name="metamask.auth")
     * @throws JsonException
     * @throws Exception
     */
    public function auth(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);

        $publicAddress = $data['publicAddress'] ?? null;
        $signature = $data['signature'] ?? null;

        // TODO: Get user nonce by publicAddress
        $nonce = 'abc1234567890';
        $message = 'I am signing my one-time nonce: ' . $nonce;

        // Verify digital signature
        $recoveredAddr = Ethereum::personalEcRecover($message, new EthD($signature));

        if ($success = (strtoupper($recoveredAddr) === strtoupper($publicAddress))) {
            // TODO: Implement user authentication
        }

        return $this->json([
            'success' => $success,
            'data' => [
                'publicAddress' => $publicAddress,
            ],
        ]);
    }

    /**
     * @Route("/api/v1/metamask/signup", methods="POST", name="metamask.signup")
     * @throws JsonException
     */
    public function signup(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);

        $publicAddress = $data['publicAddress'] ?? null;

        // TODO: Generate Nonces. For each user in the database, generate a random string in the nonce field. For example, nonce can be a big random integer.
        $nonce = 'abc1234567890';

        return $this->json([
            'publicAddress' => $publicAddress,
            'nonce' => $nonce,
        ]);
    }

    /**
     * @Route("/api/v1/metamask/user/{publicAddress}", methods="GET", name="metamask.user")
     */
    public function user(string $publicAddress): JsonResponse
    {
        // TODO: We are looking for a user at the publicAddress if there is then we return publicAddress, nonce

        return $this->json([]);
    }
}
