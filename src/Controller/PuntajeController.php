<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\Puntaje;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/puntaje")
 */
class PuntajeController extends AbstractController
{

    /**
     * @Route("/new", name="puntaje_new", methods={"POST"})
     */
    public function new(Request $request): JsonResponse
    {
        $usuario = $this->getUser();
        $token = $request->request->get('token');
        if (!$this->isCsrfTokenValid($usuario->getId(), $token)) {
            return new JsonResponse(['Token de seguridad invalido'], 403);
        }

        $postId = $request->get('post');
        $entityManager = $this->getDoctrine()->getManager();
        $puntajeRepo = $entityManager->getRepository(Puntaje::class);
        $result = $puntajeRepo->getVotoUsuario($postId, $usuario->getId());
        $puntaje = $result ? $result : new Puntaje();

        $statusCode = 200;
        if (null === $puntaje->getId()) {
            $puntaje->setPost($entityManager->getRepository(Post::class)->find($postId));
            $puntaje->setUsuario($usuario);
            $statusCode = 201;
        }

        $puntaje->setValor($request->get('puntos'));
        $puntaje->setFecha(new \DateTime());

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($puntaje);
        $entityManager->flush();

        $result = $puntajeRepo->count(['post' => $postId]);

        return new JsonResponse(['total' => round($result)], $statusCode);

    }

}
