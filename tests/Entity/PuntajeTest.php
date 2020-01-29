<?php

namespace App\Tests\Entity;

use App\Entity\Post;
use App\Entity\Puntaje;
use App\Entity\Usuario;
use App\Tests\BaseEntityTestCase;

class PuntajeTest extends BaseEntityTestCase
{

    /**
     * @return Puntaje
     */
    protected function newEntityWithRelations(): Puntaje
    {
        $entity = new Puntaje();
        $entity->setPost(new Post());
        $entity->setUsuario(new Usuario());

        return $entity;
    }

    public function testValor()
    {
        $entity = $this->newEntityWithRelations();

        $textos = [
            'message' => 'This value should not be blank.',
            'property' => 'valor',
        ];
        $this->validarAssert($entity, $textos);

        $entity->setValor(0);
        $textos = [
            'message' => 'This value should be between "1" and "5".',
            'property' => 'valor',
        ];
        $this->validarAssert($entity, $textos);

        $entity->setValor(6);
        $textos = [
            'message' => 'This value should be between "1" and "5".',
            'property' => 'valor',
        ];
        $this->validarAssert($entity, $textos);
    }

    public function testFecha()
    {
        $entity = $this->newEntityWithRelations();
        $entity->setValor(3);

        $textos = [
            'message' => 'This value should not be blank.',
            'property' => 'fecha',
        ];
        $this->validarAssert($entity, $textos);
    }

}
