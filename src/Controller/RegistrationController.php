<?php

namespace App\Controller;

use App\Entity\Usuario;
use App\Form\RegistrationFormType;
use App\Security\LoginFormAutenticadorAuthenticator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/registro", name="app_register")
     */
    public function register(
        Request $request,
        UserPasswordEncoderInterface $passwordEncoder,
        GuardAuthenticatorHandler $guardAuthenticatorHandler,
        LoginFormAutenticadorAuthenticator $loginFormAutenticadorAuthenticator
    ): Response
    {
        $user = new Usuario();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setRoles(['ROLE_USER']);
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            // do anything else you need here, like send an email
            $this->addFlash(
                'success',
                'Usuario registrado con exito, bienvenido(a)!'
            );

            return $guardAuthenticatorHandler->authenticateUserAndHandleSuccess(
                    $user,
                    $request,
                    $loginFormAutenticadorAuthenticator,
                    'main'
                );
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
