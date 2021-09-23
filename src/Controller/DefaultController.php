<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\User\Entity\User\Email;
use App\Model\User\Entity\User\Id;
use App\Model\User\Entity\User\Name;
use App\Model\User\Entity\User\User;
use App\Model\User\Entity\User\UserRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use DateTimeImmutable;

class DefaultController extends AbstractController
{
    public function register(Request $request, UserPasswordHasherInterface $encoder, JWTTokenManagerInterface $JWTTokenManager, UserRepository $userRepository): Response
    {
//        $user = $userRepository->get(new Id('41307766-b793-430d-9561-71e4e28493c1'));
//        return new Response(sprintf('JWT: %s', $JWTTokenManager->create($user)));

        $em = $this->getDoctrine()->getManager();

        $username = $request->request->get('_username');
        $password = $request->request->get('_password');

        $user = User::create(Id::next(), new DateTimeImmutable(), new Name('first name','second name'), new Email($username));
        $user->setPassword($encoder->hashPassword($user, $password));
        $user->setUsername($username);

        $em->persist($user);
        $em->flush();

        return new Response(sprintf('User %s successfully created. JWT: %s', $user->getUserIdentifier(), $JWTTokenManager->create($user)));
    }
}
