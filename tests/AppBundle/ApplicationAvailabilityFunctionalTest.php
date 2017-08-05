<?php

namespace Tests\AppBundle;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApplicationAvailabilityFunctionalTest extends WebTestCase
{
    public function testHomePage()
    {
        $client = self::createClient();
        $client->request('GET', '/');

        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    public function testSetLocale()
    {
        $client = self::createClient();
        $client->request('GET', '/setLocale/en');

        $this->assertTrue($client->getResponse()->isRedirect());
        $client->followRedirect();

        $this->assertTrue($client->getResponse()->isSuccessful());
    }
}