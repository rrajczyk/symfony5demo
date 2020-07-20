<?php

// tests/Controller/ApiUserControllerTest.php
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApiUserControllerTest extends WebTestCase
{
    public function testApiUser()
    {
        $client = static::createClient();

        $client->request('GET', '/api/users/get');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testApiUserSorts()
    {
        $client = static::createClient();

        $client->request('GET', '/api/users/get?page=2&max=2');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}