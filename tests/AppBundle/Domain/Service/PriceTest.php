<?php

namespace Test\AppBundle\Domain\Service;

use AppBundle\Domain\Entity\Command;
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
    private $command;

    public function setUp()
    {
        $command = new Command();

        $ticket = new Ticket();
        $ticket->setCreatedAt(new \DateTime('now'));
        $ticket->setBirthday(new \DateTime('1991-09-01'));
        $ticket->setReduction(false);

        $command->addTicket($ticket);

        $this->ticket = $ticket;
        $this->command = $command;
        $this->calculator = new PriceCalculator();
    }

    public function testAveragePrice()
    {
        $this->calculator->calculatePriceFromCommand($this->command);
        $this->assertEquals(16, $this->ticket->getPrice());
    }

    public function testSeniorPrice()
    {
        $this->ticket->setBirthday(new \DateTime('1950-09-01'));
        $this->calculator->calculatePriceFromCommand($this->command);
        $this->assertEquals(12, $this->ticket->getPrice());
    }

    public function testJuniorPrice()
    {
        $this->ticket->setBirthday(new \DateTime('2010-09-01'));
        $this->calculator->calculatePriceFromCommand($this->command);
        $this->assertEquals(8, $this->ticket->getPrice());
    }

    public function testVeryYoungPrice()
    {
        $this->ticket->setBirthday(new \DateTime('2015-09-01'));
        $this->calculator->calculatePriceFromCommand($this->command);
        $this->assertEquals(0, $this->ticket->getPrice());
    }

    public function testPromoPrice()
    {
        $this->ticket->setReduction(true);
        $this->calculator->calculatePriceFromCommand($this->command);
        $this->assertEquals(10, $this->ticket->getPrice());
    }

    public function testPriceCommand()
    {
        $command = new Command();

        for ($i = 0; $i < 3; $i++) {
            $ticket = new Ticket();
            $ticket->setBirthday(new \DateTime('1991-09-01'));
            $command->addTicket($ticket);
        }

        $this->calculator->calculatePriceFromCommand($command);

        $this->assertEquals(48, $command->getPrice());
    }
}
