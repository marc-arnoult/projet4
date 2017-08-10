<?php

namespace Test\AppBundle\Action;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomeActionTest extends WebTestCase
{
    public function testHomePage()
    {
        $client = self::createClient();
        $client->request('GET', '/');

        $this->assertTrue($client->getResponse()->isSuccessful());
    }
}

