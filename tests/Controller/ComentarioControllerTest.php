<?php

namespace App\Tests\Controller;

use App\Tests\BaseControllerTestCase;

class ComentarioControllerTest extends BaseControllerTestCase
{
    public function testResponderComentario()
    {
        $this->loginUsuario();
        $client = $this->client;

        $crawler = $client->xmlHttpRequest('GET', '/comentario/new', ['comentarioId' => 2]);
        $this->assertResponseIsSuccessful();
        $this->assertEquals(1, $crawler->filter('form[name="comentario"]')->count());
        $inputs = $crawler->selectButton('Enviar')->form()->getValues();
        $this->assertEquals(1, $inputs['comentario[post]']);
        $this->assertEquals(2, $inputs['comentario[padre]']);
    }
}
