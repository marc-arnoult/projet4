<?php

namespace Test\AppBundle\EventListener;

use AppBundle\EventListener\LocaleListener;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage;
use Symfony\Component\HttpFoundation\Session\Storage\MockFileSessionStorage;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\HttpKernel;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\HttpKernel\KernelEvents;

class LocaleListenerTest extends WebTestCase
{
    public function testSessionLocaleIsEn()
    {
        $client = static::createClient();
        $client->request('GET', '/setLocale/en');
        $client->followRedirect();
        $this->assertEquals('en', $client->getContainer()->get('session')->get('_locale'));
    }

    public function testSessionLocaleIsfr()
    {
        $client = static::createClient();
        $client->request('GET', '/setLocale/fr');
        $client->followRedirect();
        $this->assertEquals('fr', $client->getContainer()->get('session')->get('_locale'));
    }

    public function testGetSubscribedEvents()
    {
        $subscribed = LocaleListener::getSubscribedEvents();
        $this->assertArrayHasKey(KernelEvents::REQUEST, $subscribed);
    }
}