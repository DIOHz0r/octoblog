<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BaseControllerTestCaseTest extends WebTestCase
{

    /**
     * @var KernelBrowser
     */
    protected $client;


    public function loginUsuario($usuario = 'usuario@octoblog.local', $clave = 'usuario123' )
    {
        $this->client = static::createClient([],[
                'PHP_AUTH_USER' => $usuario,
                'PHP_AUTH_PW' => $clave,
        ]);
    }
}
