<?php

namespace Tests\AppBundle;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApplicationAvailabilityFunctionalTest extends WebTestCase
{
    /**
     * @param $url
     *
     * @dataProvider urlProvider
     */
    public function test_page_is_successful($url)
    {
        $client = self::createClient();
        $client->request('GET', $url);

        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    public function test_setLocale_redirect()
    {
        $client = self::createClient();
        $client->request('GET', '/setLocale/en');

        $this->assertTrue($client->getResponse()->isRedirect());
        $client->followRedirect();

        $this->assertTrue($client->getResponse()->isSuccessful());
    }
    public function urlProvider()
    {
        return [
            ['/']
        ];
    }
}