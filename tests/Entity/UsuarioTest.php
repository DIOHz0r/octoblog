<?php

namespace App\Tests\Entity;

use App\Entity\Usuario;
use App\Tests\BaseEntityTestCase;

class UsuarioTest extends BaseEntityTestCase
{

    public function testToString()
    {
        $entity = new Usuario();
        $entity->setNombre('foo');
        $entity->setApellido('bar');

        $this->assertEquals('foo bar', $entity);
    }

    public function testValidarEmail()
    {
        $this->markTestSkipped('Correjir Error: Class \'doctrine.orm.validator.unique\' not found');
        $entity = new Usuario();

        $textos = [
            'message' => 'This value should not be blank.',
            'property' => 'email',
        ];
        $this->validarAssert($entity, $textos);

        $entity->setEmail('foo');
        $textos = [
            'message' => 'This value is not a valid email address.',
            'property' => 'email',
        ];
        $this->validarAssert($entity, $textos);
    }

    public function testValidarNombreCompleto()
    {
        $this->markTestSkipped('Correjir Error: Class \'doctrine.orm.validator.unique\' not found');
        $entity = new Usuario();
        $entity->setEmail('foo@bar.local');

        $textos = [
            'message' => 'This value should not be blank.',
            'property' => 'nombre',
        ];
        $this->validarAssert($entity, $textos);

        $entity->setNombre('foo');
        $textos = [
            'message' => 'This value should not be blank.',
            'property' => 'apellido',
        ];
        $this->validarAssert($entity, $textos);
    }

}
