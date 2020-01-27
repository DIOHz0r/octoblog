<?php

namespace App\Tests\Entity;

use App\Entity\Comentario;
use App\Entity\Post;
use App\Tests\BaseEntityTestCase;

class ComentarioTest extends BaseEntityTestCase
{

    protected function newEntityWithRelations()
    {
        $entity = new Comentario();
        $entity->setPost(new Post());
        return $entity;
    }

    public function testValidarMensaje()
    {
        $entity = $this->newEntityWithRelations();
        $entity->setPadre(null);
        $entity->setFecha(new \DateTime());

        $textos = [
            'message' => 'This value should not be blank.',
            'property' => 'mensaje',
        ];
        $this->validarAssert($entity, $textos);

        $entity->setMensaje('foo');
        $textos = [
            'message' => 'This value is too short. It should have 4 characters or more.',
            'property' => 'mensaje',
        ];
        $this->validarAssert($entity, $textos);
    }
}
