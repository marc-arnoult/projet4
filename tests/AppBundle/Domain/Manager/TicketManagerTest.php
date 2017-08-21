<?php

namespace Test\AppBundle\Domain\Manager;

use AppBundle\Domain\Manager\TicketManager;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

class TicketManagerTest extends WebTestCase
{
    public function testGetTicketsWithParam()
    {
        $kernel = self::$kernel;
        $kernel->boot();

        $request = new Request();
        $request->query->set('day', '2017-08-20');
        $day = $request->query->get('day');

        $manager = $kernel->getContainer()->get(TicketManager::class);
        $payload = $manager->getTicketsRemaining($day);
        $this->assertEquals(990, $payload->get('content'));
    }
}
