<?php

// tests/Controller/ApiEventControllerTest.php
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApiEventControllerTest extends WebTestCase
{
    public function testApiEvent()
    {
        $client = static::createClient();

        $client->request('GET', '/api/events/get');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testApiEventSorts()
    {
        $client = static::createClient();

        $client->request('GET', '/api/events/get?page=2&max=2');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}