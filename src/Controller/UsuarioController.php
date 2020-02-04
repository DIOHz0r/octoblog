<?php

namespace App\Controller;

use App\Entity\Usuario;
use App\Form\UsuarioType;
use App\Repository\UsuarioRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/usuario")
 */
class UsuarioController extends AbstractController
{
    /**
     * @Route("/", name="usuario_index", methods={"GET"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function index(UsuarioRepository $usuarioRepository): Response
    {
        return $this->render('usuario/index.html.twig', [
            'usuarios' => $usuarioRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="usuario_new", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function new(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $usuario = new Usuario();
        $form = $this->createForm(UsuarioType::class, $usuario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $plainPassword = $form->get('plain_password')->getData();
            $usuario->setPassword($passwordEncoder->encodePassword($usuario, $plainPassword));
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($usuario);
            $entityManager->flush();

            return $this->redirectToRoute('usuario_index');
        }

        return $this->render('usuario/new.html.twig', [
            'usuario' => $usuario,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="usuario_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Usuario $usuario, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        if($this->getUser()->getId() != $usuario->getId() || !$this->isGranted("ROLE_ADMIN")){
            throw $this->createAccessDeniedException();
        }

        $form = $this->createForm(UsuarioType::class, $usuario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $plainPassword = $form->get('plain_password')->getData();
            if ($plainPassword) {
                $usuario->setPassword($passwordEncoder->encodePassword($usuario, $plainPassword));
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($usuario);
            $entityManager->flush();

            return $this->redirectToRoute('usuario_index');
        }

        return $this->render('usuario/edit.html.twig', [
            'usuario' => $usuario,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="usuario_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Usuario $usuario): Response
    {
        if ($this->isCsrfTokenValid('delete'.$usuario->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($usuario);
            $entityManager->flush();
        }

        return $this->redirectToRoute('usuario_index');
    }
}
