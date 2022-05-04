<?php

namespace App\Controller\Default;

use App\Entity\User\Section;
use App\Entity\User\User;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager, \Swift_Mailer $mailer): Response
    {
        $user = new User();
        $sectionsList = $entityManager->getRepository(Section::class)->findAll();
        
        $form = $this->createForm(RegistrationFormType::class, $user, ['sections' => $sectionsList]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $info = 'Un email de confirmation a été envoyé.';
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $user->setRoles(["ROLE_USER"]);
            $entityManager->persist($user);
            $entityManager->flush();
            
            $userId = $entityManager->getRepository(User::class)->findOneBy(['email' => $user->getEmail()])->getId();

            $urlConfirmation = $this->generateUrl(
                'confirm_account',
                [
                    'userId' => $userId,
                    'token' => $user->getComfirmToken()
                ],
                UrlGeneratorInterface::ABSOLUTE_URL
            );

            $email = (new \Swift_Message())
            ->setFrom($_ENV['MAILER_USER'])
            ->setTo($form->get('email')->getData())
            ->setSubject('ESGI Gaming Association confirmation')
            ->setBody(
                $this->renderView('email/userConfirmationRegisterEmail.html.twig', [
                    'name' => $form->get('name')->getData(),
                    'url_confirmation' => $urlConfirmation
                ]),
                'text/html'
            );
            $mailer->send($email);

            return $this->redirectToRoute('login', ['info' => $info]);
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
