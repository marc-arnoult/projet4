<?php

namespace Test\AppBundle\Domain\Service;

use AppBundle\Domain\Entity\Ticket;
use AppBundle\Domain\Service\PriceCalculator;
use PHPUnit\Framework\TestCase;

class PriceTest extends TestCase
{
    /**
     * @var Ticket
     */
    private $ticket;

    /**
     * @var PriceCalculator
     */
    private $calculator;

    public function setUp()
    {
        $ticket = new Ticket();
        $ticket->setCreatedAt(new \DateTime('now'));
        $ticket->setBirthday(new \DateTime('1991-09-01'));
        $ticket->setReduction(false);

        $this->ticket = $ticket;
        $this->calculator = new PriceCalculator();
    }

    public function testAveragePrice()
    {
        $this->calculator->calculatePrice($this->ticket);
        $this->assertEquals(16, $this->ticket->getPrice());
    }

    public function testSeniorPrice()
    {
        $this->ticket->setBirthday(new \DateTime('1950-09-01'));
        $this->calculator->calculatePrice($this->ticket);
        $this->assertEquals(12, $this->ticket->getPrice());
    }

    public function testJuniorPrice()
    {
        $this->ticket->setBirthday(new \DateTime('2010-09-01'));
        $this->calculator->calculatePrice($this->ticket);
        $this->assertEquals(8, $this->ticket->getPrice());
    }

    public function testVeryYoungPrice()
    {
        $this->ticket->setBirthday(new \DateTime('2015-09-01'));
        $this->calculator->calculatePrice($this->ticket);
        $this->assertEquals(0, $this->ticket->getPrice());
    }

    public function testPromoPrice()
    {
        $this->ticket->setReduction(true);
        $this->calculator->calculatePrice($this->ticket);
        $this->assertEquals(10, $this->ticket->getPrice());
    }
}
