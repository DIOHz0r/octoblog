<?php

namespace App\Tests\Controller;

use App\Tests\BaseControllerTestCaseTest;

class PostControllerTest extends BaseControllerTestCaseTest
{
    public function testVistaSinLogin()
    {
        $client = static::createClient();

        // pagina de inicio
        $client->request('GET', '/');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextNotContains('nav', 'Usuario');
        $this->assertSelectorTextContains('header', 'Registrarse');
        $this->assertSelectorTextContains('header', 'Iniciar Sesión');

        // pagina del post
        $client->clickLink('Leer más');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextNotContains('aside', 'Editar');
        $this->assertSelectorTextNotContains('aside', 'Borrar');
        $this->assertSelectorTextContains('section', 'Inicia sesión para comentar');
    }

    public function testVistaConLogin()
    {
        $this->loginUsuario();
        $client = $this->client;

        // pagina de inicio
        $client->request('GET', '/');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextNotContains('nav', 'Usuarios');

        // pagina del post
        $client->request('GET', '/post/2');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('aside', 'Editar');
        $this->assertSelectorTextContains('aside', 'Borrar');
        $this->assertSelectorTextContains('a.btn-outline-secondary', 'Responder');
        $this->assertSelectorTextContains('section', 'Agregar comentario nuevo');

        $crawler = $client->clickLink('Crear Post');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('main h1', 'Crear nuevo post');
        $this->assertEquals(1, $crawler->filter('main form[name="post"]')->count());
    }
}
