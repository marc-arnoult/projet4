<?php

namespace Test\AppBundle\Domain\Service;

use AppBundle\Domain\Entity\Ticket;
use AppBundle\Domain\Service\PriceCalculator;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;

class PriceTest extends TestCase
{
    public function testPriceAdult()
    {
        $tickets = new ArrayCollection();

        $ticket = new Ticket();
        $ticket->setBirthday(new \DateTime('1991-09-01'));
        $tickets->add($ticket);

        $calculator = new PriceCalculator();
        $this->assertEquals(16, $calculator->calculate($tickets));
    }

    public function testPriceUnderFourYeahOld()
    {
        $tickets = new ArrayCollection();

        $ticket = new Ticket();
        $ticket->setBirthday(new \DateTime('2015-09-01'));
        $tickets->add($ticket);

        $calculator = new PriceCalculator();
        $this->assertEquals(0, $calculator->calculate($tickets));
    }

    public function testPriceChild()
    {
        $tickets = new ArrayCollection();

        $ticket = new Ticket();
        $ticket->setBirthday(new \DateTime('2010-09-01'));
        $tickets->add($ticket);

        $calculator = new PriceCalculator();
        $this->assertEquals(8, $calculator->calculate($tickets));
    }

    public function testPriceSenior()
    {
        $tickets = new ArrayCollection();

        $ticket = new Ticket();
        $ticket->setBirthday(new \DateTime('1950-09-01'));
        $tickets->add($ticket);

        $calculator = new PriceCalculator();
        $this->assertEquals(12, $calculator->calculate($tickets));
    }

    public function testPricePromo()
    {
        $tickets = new ArrayCollection();

        $ticket = new Ticket();
        $ticket->setBirthday(new \DateTime('1950-09-01'));
        $ticket->setReduction(true);
        $tickets->add($ticket);

        $calculator = new PriceCalculator();
        $this->assertEquals(10, $calculator->calculate($tickets));
    }

    public function testPriceGroup()
    {
        $tickets = new ArrayCollection();

        $ticket = new Ticket();
        $ticket->setBirthday(new \DateTime('1950-09-01'));
        $tickets->add($ticket);

        $ticket2 = new Ticket();
        $ticket2->setBirthday(new \DateTime('1950-09-01'));
        $tickets->add($ticket2);

        $ticket3 = new Ticket();
        $ticket3->setBirthday(new \DateTime('2010-09-01'));
        $tickets->add($ticket3);

        $calculator = new PriceCalculator();
        $this->assertEquals(32, $calculator->calculate($tickets));
    }
}
