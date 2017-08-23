<?php

namespace Test\AppBundle\Domain\Entity;


use AppBundle\Domain\Entity\Command;
use AppBundle\Domain\Entity\Ticket;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class CommandTest extends WebTestCase
{
    public function testCommand()
    {
        $ticket = new Ticket();

        $command = new Command();
        $command->setEmail('marc.arnoult@hotmail.fr');
        $command->setType('Journée');
        $command->setPrice(12);
        $command->setEntryAt(new \DateTime('2017-09-09'));
        $command->setPayment(true);
        $command->addTicket($ticket);

        $date = new \DateTime('NOW');
        $command->setCreatedAt($date);

        $this->assertEquals('marc.arnoult@hotmail.fr', $command->getEmail());
        $this->assertEquals('Journée', $command->getType());
        $this->assertEquals($date, $command->getCreatedAt());
        $this->assertEquals(new \DateTime('2017-09-09'), $command->getEntryAt());
        $this->assertEquals(12, $command->getPrice());
        $this->assertEquals(null, $command->getId());
        $this->assertTrue($command->getPayment());
        $this->assertInstanceOf(ArrayCollection::class, $command->getTickets());
        $this->assertInstanceOf(Ticket::class, $command->getTickets()->get(0));

        $this->assertTrue($command->containTicket($ticket));

        $command->removeTicket($ticket);
        $this->assertEmpty($command->getTickets()->get(0));
    }
}
