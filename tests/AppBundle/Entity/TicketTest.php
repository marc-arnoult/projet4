<?php

namespace Test\AppBundle\Entity;

use AppBundle\Entity\Command;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use AppBundle\Entity\Ticket;

class TicketTest extends WebTestCase
{
    public function testTicket()
    {
        $now = new \DateTime('NOW');
        $birthday = new \DateTime('1991-09-01');
        $entry = new \DateTime('2017-09-09');

        $command = new Command();
        $ticket = new Ticket();

        $ticket->setCreatedAt($now);
        $ticket->setCommand($command);
        $ticket->setBirthday($birthday);
        $ticket->setCountry('France');
        $ticket->setFirstName('Marc');
        $ticket->setLastName('Arnoult');
        $ticket->setPrice(12);
        $ticket->setEntryAt($entry);
        $ticket->setReduction(false);

        $this->assertEquals($now, $ticket->getCreatedAt());
        $this->assertInstanceOf(Command::class, $ticket->getCommand());
        $this->assertEquals($birthday, $ticket->getBirthday());
        $this->assertEquals('France', $ticket->getCountry());
        $this->assertEquals('Marc', $ticket->getFirstName());
        $this->assertEquals('Arnoult', $ticket->getLastName());
        $this->assertEquals(12, $ticket->getPrice());
        $this->assertEquals($entry, $ticket->getEntryAt());
        $this->assertEquals(false, $ticket->getReduction());
        $this->assertEquals(null, $ticket->getId());
    }
}