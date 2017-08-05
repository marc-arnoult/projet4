<?php

namespace Test\AppBundle\EventListener;

use AppBundle\EventListener\LocaleListener;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
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

    public function testLocaleListenerIsEn()
    {
        $kernel = self::$kernel;
        $request = new Request();
        $listener = new LocaleListener('en');
        $event = new GetResponseEvent($kernel, $request, Kernel::MASTER_REQUEST);

        $dispatcher = new EventDispatcher();
        $dispatcher->addListener('kernel.request', [$listener, 'onKernelRequest']);
        $dispatcher->dispatch('kernel.request', $event);
        $listeners = $dispatcher->getListeners('kernel.request');
        $this->assertAttributeEquals('en', 'defaultLocale', $listeners[0][0]);
    }

    public function testLocaleListenerIsFr()
    {
        $kernel = self::$kernel;
        $request = new Request();
        $listener = new LocaleListener('fr');
        $event = new GetResponseEvent($kernel, $request, Kernel::MASTER_REQUEST);

        $dispatcher = new EventDispatcher();
        $dispatcher->addListener('kernel.request', [$listener, 'onKernelRequest']);
        $dispatcher->dispatch('kernel.request', $event);
        $listeners = $dispatcher->getListeners('kernel.request');
        $this->assertAttributeEquals('fr', 'defaultLocale', $listeners[0][0]);
    }
}