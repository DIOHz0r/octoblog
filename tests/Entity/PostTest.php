<?php

namespace App\Tests\Entity;

use App\Entity\Post;
use App\Tests\BaseEntityTestCase;

class PostTest extends BaseEntityTestCase
{

    public function testValidarTitulo()
    {
        $entity = new Post();

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
        $entity = new Post();
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
        $entity = new Post();
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
