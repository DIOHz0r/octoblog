<?php

namespace App\Tests\Entity;

use App\Entity\Usuario;
use App\Tests\BaseEntityTestCase;

class UsuarioTest extends BaseEntityTestCase
{
    public function testValidarEmail()
    {
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
