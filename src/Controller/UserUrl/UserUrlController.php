<?php

namespace App\Controller\UserUrl;

use App\Repository\User\UserRepository;
use App\Service\User\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserUrlController extends AbstractController
{
    #[Route('/{username}', name: 'user_url', priority: -1)]
    public function index(string $username, UserService $userService, UserRepository $userRepository): Response
    {
        $dynanicUrl = $userService->checkUrlIsValidUsername($username, $userRepository);

        if ($dynanicUrl === null) {
            return $this->render('user_url/error_username.html.twig', [
                'username' => $username
            ]);
        }

        return $this->render('user_url/index.html.twig', [
            'username' => $username
        ]);
    }
}
