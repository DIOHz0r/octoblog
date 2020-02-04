<?php

namespace App\Tests\Controller;

use App\Tests\BaseControllerTestCase;

class UsuarioTest extends BaseControllerTestCase
{
    public function testEditarPerfil()
    {
        $this->loginUsuario();
        $client = $this->client;

        $crawler = $client->request('GET', '/usuario/2/edit');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('main h1', 'Perfil de usuario');
        $this->assertEquals(1, $crawler->filter('main form[name="usuario"]')->count());

        $crawler = $client->request('GET', '/usuario/3/edit');
        $this->assertEquals(403, $client->getResponse()->getStatusCode());
    }

    public function testListarUsuarios()
    {
        // usuario regular
        $this->loginUsuario();
        $client = $this->client;

        $client->request('GET', '/usuario/');
        $this->assertEquals(403, $client->getResponse()->getStatusCode());

        // admin
        $this->loginUsuario('admin@octoblog.local', 'admin123');
        $client = $this->client;

        $crawler = $client->request('GET', '/usuario/');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('main h1', 'Lista de usuarios');
        $this->assertGreaterThan(2, $crawler->filter('tbody td')->count());

        $crawler = $client->clickLink('Crear nuevo');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('main h1', 'Crear nuevo usuario');
        $this->assertEquals(1, $crawler->filter('main form[name="usuario"]')->count());
    }
}
