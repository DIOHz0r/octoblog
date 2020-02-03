<?php

namespace App\Controller;

use App\Entity\Comentario;
use App\Form\ComentarioType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/comentario")
 */
class ComentarioController extends AbstractController
{

    /**
     * @Route("/new", name="comentario_new", methods={"GET","POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $comentario = new Comentario();

        // cuando responden a un mensaje asignamos el padre
        if ($comentarioId = $request->query->get('comentarioId')) {
            $replyTo = $entityManager->getRepository(Comentario::class)->find($comentarioId);
            $comentario->setPadre($replyTo);
            $comentario->setPost($replyTo->getPost());
        }

        $form = $this->createForm(ComentarioType::class, $comentario);
        $form->handleRequest($request);

        $responseCode = 200;
        $isSubmitted = $form->isSubmitted();
        if ($isSubmitted && $isValid = $form->isValid()) {
            $entityManager->persist($comentario);
            $entityManager->flush();

            if ($request->isXmlHttpRequest()) {
                $html = $this->renderView('comentario/_show.html.twig', ['comentario' => $comentario]);
                return new Response($html, 201);
            }
        } elseif ($isSubmitted) {
            $responseCode = 400;
        }

        if ($request->isXmlHttpRequest()) {
            $html = $this->renderView(
                'comentario/_form.html.twig',
                [
                    'action' => $this->generateUrl('comentario_new'),
                    'form' => $form->createView()
                ]
            );

            return new Response($html, $responseCode);
        }

        return $this->render('comentario/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="comentario_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Comentario $comentario): Response
    {
        $form = $this->createForm(ComentarioType::class, $comentario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return new JsonResponse([], 202);
        }

        return $this->render('comentario/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="comentario_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Comentario $comentario): Response
    {
        if ($this->isCsrfTokenValid('delete'.$comentario->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($comentario);
            $entityManager->flush();
        }

        return $this->redirectToRoute('comentario_index');
    }
}
