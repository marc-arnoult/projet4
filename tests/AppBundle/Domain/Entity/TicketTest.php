<?php

namespace Test\AppBundle\Domain\Entity;

use AppBundle\Domain\Entity\Command;
use AppBundle\Domain\Entity\Ticket;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TicketTest extends WebTestCase
{
    public function testTicket()
    {
        $now = new \DateTime('NOW');
        $birthday = new \DateTime('1991-09-01');

        $command = new Command();
        $ticket = new Ticket();

        $ticket->setCommand($command);
        $ticket->setBirthday($birthday);
        $ticket->setCountry('France');
        $ticket->setFirstName('Marc');
        $ticket->setLastName('Arnoult');
        $ticket->setReduction(false);
        $ticket->setCreatedAt($now);
        $ticket->setPrice(16);

        $this->assertInstanceOf(Command::class, $ticket->getCommand());
        $this->assertEquals(1000, Ticket::TICKET_LIMIT);
        $this->assertEquals($now->format('Y-m-d'), $ticket->getCreatedAt()->format('Y-m-d'));
        $this->assertEquals($birthday, $ticket->getBirthday());
        $this->assertEquals('France', $ticket->getCountry());
        $this->assertEquals('Marc', $ticket->getFirstName());
        $this->assertEquals(16, $ticket->getPrice());
        $this->assertEquals('Arnoult', $ticket->getLastName());
        $this->assertEquals(false, $ticket->getReduction());
        $this->assertEquals(null, $ticket->getId());
    }
}