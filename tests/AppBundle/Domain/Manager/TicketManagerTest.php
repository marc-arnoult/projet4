<?php

namespace Test\AppBundle\Domain\Manager;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

class TicketManagerTest extends WebTestCase
{
    public function testGetTickets()
    {
        $kernel = self::$kernel;
        $kernel->boot();

        $requestStack = $kernel->getContainer()->get('request_stack');
        $requestStack->push(new Request());

        $manager = $kernel->getContainer()->get('AppBundle\Domain\Manager\TicketManager');
        $this->assertNotEmpty($manager->getTickets());
    }

    public function testGetTicketsWithParam()
    {
        $kernel = self::$kernel;
        $kernel->boot();

        $request = new Request();
        $request->query->set('day', '2017-09-09');

        $requestStack = $kernel->getContainer()->get('request_stack');
        $requestStack->push($request);

        $manager = $kernel->getContainer()->get('AppBundle\Domain\Manager\TicketManager');

        $data = $manager->getTickets();
        $this->assertEquals(990, $data['content']);
    }
}