<?php

namespace App\Controller;

use App\Entity\Comentario;
use App\Entity\Post;
use App\Entity\Puntaje;
use App\Form\PostType;
use App\Repository\PostRepository;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/post")
 */
class PostController extends AbstractController
{
    /**
     * @Route("/", name="post_index", methods={"GET"})
     */
    public function index(PostRepository $postRepository): Response
    {
        return $this->render('post/index.html.twig', [
            'posts' => $postRepository->findBy([],['fecha'=>'DESC']),
        ]);
    }

    /**
     * @Route("/new", name="post_new", methods={"GET","POST"})
     */
    public function new(Request $request, FileUploader $fileUploader): Response
    {
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $upload_imagen = $form['upload_imagen']->getData();
            if ($upload_imagen) {
                $upload_imagen = $fileUploader->upload($upload_imagen);
                $post->setImagen($upload_imagen);
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($post);
            $entityManager->flush();

            return $this->redirectToRoute('post_index');
        }

        return $this->render('post/new.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="post_show", methods={"GET"})
     */
    public function show(Post $post, EntityManagerInterface $em): Response
    {
        $comentariosRepo = $em->getRepository(Comentario::class);
        $puntajeRepo = $em->getRepository(Puntaje::class);

        $comentarios = $comentariosRepo->findBy(['post' => $post], ['id' => 'ASC', 'padre' => 'ASC', 'fecha' => 'ASC']);
        $puntaje = $puntajeRepo->getPostAverage($post);
        return $this->render('post/show.html.twig', [
            'post' => $post,
            'comentarios' => $comentarios,
            'puntaje' => $puntaje,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="post_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Post $post, FileUploader $fileUploader): Response
    {
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $upload_imagen = $form['upload_imagen']->getData();
            if ($upload_imagen) {
                $upload_imagen = $fileUploader->upload($upload_imagen);
                $post->setImagen($upload_imagen);
            }
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('post_index');
        }

        return $this->render('post/edit.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="post_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Post $post): Response
    {
        if ($this->isCsrfTokenValid('delete'.$post->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($post);
            $entityManager->flush();
        }

        return $this->redirectToRoute('post_index');
    }
}
