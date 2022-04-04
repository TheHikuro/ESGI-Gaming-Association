<?php

namespace App\Controller\Default;

use App\Entity\User\User;
use App\Repository\User\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class AccountConfirmationController extends AbstractController
{
    #[Route('/confirm/{userId}/{token}', name: 'confirm_account')]
    public function confirm_account($userId, $token, EntityManagerInterface $entityManager): Response
    {
        $info = null;
        $user = $entityManager->getRepository(User::class)->findOneBy(['id' => $userId]);

        if ($user != null) {
            if ($user->getComfirmToken() != null) {
                if ($user->getComfirmToken() == $token) {
                    $user->setComfirmToken(null);
                    $entityManager->flush();
                    $info = 'Votre compte a été activé.';
                }
            }
        }
        return $this->redirectToRoute('login', ['info' => $info]);
    }

    #[Route('/recover/{userId}/{token}', name: 'recover_account')]
    public function recover_email($userId, $token, Request $request, UserRepository $userRepository, EntityManagerInterface $entityManager, UserPasswordHasherInterface $hasher): Response
    {
        $info = null;
        $error = null;

        $user = $userRepository->findOneBy(['id' => $userId]);

        if ($user && $token == $user->getPasswordRecoverToken()) {
            if ($request->request->get('password') == $request->request->get('confirm_password') && $request->request->get('password') != null) {
                $user->setPassword($hasher->hashPassword($user, $request->request->get('password')));
                $user->removePasswordToken();
                $entityManager->flush();
                $info = 'Votre compte a été réinitialisé.';
                return $this->redirectToRoute('login', ['info' => $info, 'error' => $error]);
            } elseif($request->request->get('password') != null) {
                $error = 'Les mots de passe ne correspondent pas.';
            }
            return $this->render('login/recover_account.html.twig', ['info' => $info, 'error' => $error]);
        }
        $error = 'Le lien de réinitialisation de votre compte est invalide.';
        return $this->redirectToRoute('login', ['error' => $error]);
    }

    #[Route('/recover', name: 'recover')]
    public function recover_acount(Request $request, UserRepository $userRepository, EntityManagerInterface $entityManager, \Swift_Mailer $mailer): Response
    {
        $info = null;

        if ($request->getMethod() == 'POST') {
            $user = $userRepository->findOneBy(['email' => $request->request->get('email')]);

            if ($user) {
                $user->addPasswordRecoverToken();
                $entityManager->flush();

                $urlRecover = $this->generateUrl(
                    'recover_account',
                    [
                        'userId' => $user->getId(),
                        'token' => $user->getPasswordRecoverToken()
                    ],
                    UrlGeneratorInterface::ABSOLUTE_URL
                );

                $email = (new \Swift_Message())
                    ->setFrom($_ENV['MAILER_USER'])
                    ->setTo($user->getEmail())
                    ->setSubject('ESGI Gaming Association récupération')
                    ->setBody(
                        $this->renderView('email/userRecoverEmail.html.twig', [
                            'name' => $user->getName(),
                            'url_recover' => $urlRecover
                        ]),
                        'text/html'
                    );
                $mailer->send($email);
                $info = "Un email de récupération a été envoyé.";

                return $this->redirectToRoute('login', ['info' => $info]);
            }
        }

        return $this->render('login/recover.html.twig');
    }
}
