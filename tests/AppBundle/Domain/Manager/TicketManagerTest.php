<?php

namespace Test\AppBundle\Domain\Manager;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

class TicketManagerTest extends WebTestCase
{
    public function testGetTicketsWithParam()
    {
        $kernel = self::$kernel;
        $kernel->boot();

        $request = new Request();
        $request->query->set('day', '2017-09-09');

        $requestStack = $kernel->getContainer()->get('request_stack');
        $requestStack->push($request);

        $manager = $kernel->getContainer()->get('AppBundle\Domain\Manager\TicketManager');

        $data = $manager->getTicketsRemaining();
        $this->assertEquals(990, $data['content']);
    }
}
