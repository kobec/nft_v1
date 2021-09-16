<?php

namespace App\Controller;

use App\Model\User\Entity\User\Email;
use App\Model\User\Entity\User\Id;
use App\Model\User\Entity\User\Name;
use App\Model\User\Entity\User\User;
use App\Model\User\Entity\User\UserRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class DefaultController extends AbstractController
{
    public function register(Request $request, UserPasswordHasherInterface $encoder, JWTTokenManagerInterface $JWTTokenManager, UserRepository $userRepository)
    {
        $user=$userRepository->get(new Id('60b8c898-ea6c-4e6b-837a-eda985f72c2d'));
        return new JsonResponse(['token' => $JWTTokenManager->create($user)]);
        $em = $this->getDoctrine()->getManager();

        $username = $request->request->get('_username');
        $password = $request->request->get('_password');

        $user =User::create(Id::next(), new \DateTimeImmutable(),new Name('name','second name'),new Email($username));
        $user->setPassword($encoder->hashPassword($user, $password));

        $em->persist($user);
        $em->flush();

        return new Response(sprintf('User %s successfully created', $user->getUsername()));
    }

    public function api()
    {
        return new Response(sprintf('Logged in as %s', $this->getUser()->getUsername()));
    }
}
