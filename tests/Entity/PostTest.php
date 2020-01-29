<?php

namespace App\Tests\Entity;

use App\Entity\Post;
use App\Entity\Usuario;
use App\Tests\BaseEntityTestCase;

class PostTest extends BaseEntityTestCase
{

    protected function newEntityWithRelations()
    {
        $entity = new Post();
        $entity->setAutor(new Usuario());
        return $entity;
    }

    public function testValidarTitulo()
    {
        $entity = $this->newEntityWithRelations();

        $textos = [
            'message' => 'This value should not be blank.',
            'property' => 'titulo',
        ];
        $this->validarAssert($entity, $textos);

        $entity->setTitulo('foo');
        $textos = [
            'message' => 'This value is too short. It should have 15 characters or more.',
            'property' => 'titulo',
            'set_value' => 'Lorem ipsum dolor ',
        ];
        $this->validarAssert($entity, $textos);
    }

    public function testValidarContenido()
    {
        $entity = $this->newEntityWithRelations();
        $entity->setTitulo('Lorem ipsum dolor');

        $textos = [
            'message' => 'This value should not be blank.',
            'property' => 'contenido',
        ];
        $this->validarAssert($entity, $textos);

        $entity->setContenido('foo');
        $textos = [
            'message' => 'This value is too short. It should have 25 characters or more.',
            'property' => 'contenido',
            'set_value' => 'Lorem ipsum dolor sit amet.',
        ];
        $this->validarAssert($entity, $textos);
    }

    public function testValidarFecha()
    {
        $entity = $this->newEntityWithRelations();
        $entity->setTitulo('Lorem ipsum dolor');
        $entity->setContenido('Lorem ipsum dolor sit amet.');

        $property = 'fecha';
        $textos = [
            'message' => 'This value should not be blank.',
            'property' => $property,
        ];
        $this->validarAssert($entity, $textos);
    }

}
