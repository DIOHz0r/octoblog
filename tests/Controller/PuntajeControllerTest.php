<?php

namespace App\Tests\Controller;

use App\Tests\BaseControllerTestCase;

class PuntajeControllerTest extends BaseControllerTestCase
{
    public function testNoToken()
    {
        $this->loginUsuario();
        $client = $this->client;
        $client->xmlHttpRequest('POST', '/puntaje/new', ['token'=>'foo']);

        $this->assertEquals(403, $client->getResponse()->getStatusCode());
        $this->assertJsonStringEqualsJsonString(
            '["Token de seguridad invalido"]',
            $client->getResponse()->getContent()
        );
    }
}
