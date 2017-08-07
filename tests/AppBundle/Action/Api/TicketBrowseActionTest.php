<?php

namespace Test\AppBundle\Action\Api;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TicketBrowseActionTest extends WebTestCase
{
    public function testReturnJson()
    {
        $client = self::createClient();
        $client->request('GET', '/api/ticket');

        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertJson($client->getResponse()->getContent());
    }
}
