<?php

namespace App\Tests;

use Doctrine\Common\Inflector\Inflector;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Validation;

class BaseEntityTestCase extends TestCase
{
    /**
     * @var \Symfony\Component\Validator\Validator\ValidatorInterface
     */
    protected $validator;

    public function setUp()
    {
        $this->validator = Validation::createValidatorBuilder()
            ->enableAnnotationMapping()
            ->getValidator();
    }

    /**
     * @param string $entity name
     * @param string $dependency the class name
     * @param string $method seter to be called
     */
    public function checkDependencyInjection($entity, string $dependency, string $method)
    {
        try {
            $entity->$method('objeto invalido');
            // Code that may throw an Exception or Error.
        } catch (\Throwable $t) {
            // Executed only in PHP 7, will not match in PHP 5.x
            $this->assertContains("must be an instance of App\\Entity\\".$dependency, $t->getMessage());
        }
    }

    /**
     * Rutina para obtener si el validador devolvio un resultado, el mensaje de error dado y la propiedad que valida
     *
     * @param $entity
     * @param array $argumentos a validar
     * @param bool $debug
     */
    protected function validarAssert($entity, array $argumentos, bool $debug = false)
    {
        $listaErrores = $this->validator->validate($entity);
        if ($debug) {
            dump($listaErrores);
        }
        // Validar si existen errores
        $this->assertGreaterThan(0, $listaErrores->count(), (key_exists('count', $argumentos)) ? $argumentos['count'] : '');
        $error = $listaErrores[0];
        //Validar que el mensaje de error obtenido sea el correcto
        $this->assertEquals($argumentos['message'], $error->getMessage());
        //Validar que la propiedad evaluada coincida con la que da el error
        $this->assertEquals($argumentos['property'], $error->getPropertyPath());
        //Validar la funciones set en caso de que apliquen
        if (key_exists('set_value', $argumentos) && !empty($argumentos['set_value'])) {
            $methodName = Inflector::classify($argumentos['property']);
            $setMethod = 'set'.$methodName;
            $getMethod = 'get'.$methodName;
            $this->assertInstanceOf(get_class($entity), $entity->$setMethod($argumentos['set_value']));
            $this->assertEquals($argumentos['set_value'], $entity->$getMethod());
        }
    }
}
