<?php

namespace Test\AppBundle\Action;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SetLocaleActionTest extends WebTestCase
{
    public function testIsTranslated()
    {
        $client = self::createClient();
        $client->request('GET', '/setLocale/en');
        $crawler = $client->followRedirect();

        $this->assertCount(1, $crawler->filter('h1:contains("TICKETING")'));
        $this->assertCount(1, $crawler->filter('nav a:contains("Find us")'));
        $this->assertCount(1, $crawler->filter('footer a:contains("French")'));
        $this->assertCount(1, $crawler->filter('footer a:contains("English")'));
        $this->assertCount(1, $crawler->filter('footer a:contains("Legals mentions")'));
    }
}
