<?php

declare(strict_types=1);

namespace App\Controller\Api\V1;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/api/v1/user")
     */
    public function user(): JsonResponse
    {
        $user = $this->getUser();

        return $this->json([
            'id' => $user->getUserIdentifier(),
            'username' => $user->getUsername(),
        ]);
    }
}
