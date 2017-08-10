<?php

namespace Test\AppBundle\Action\Api;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TicketBrowseActionTest extends WebTestCase
{
    public function testBadRequest()
    {
        $client = self::createClient();
        $client->request('GET', '/api/ticket');

        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertJson($client->getResponse()->getContent());
    }
}
