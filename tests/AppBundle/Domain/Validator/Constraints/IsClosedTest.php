<?php

namespace Test\AppBundle\Domain\Validator\Constraints;


use AppBundle\Domain\Entity\Command;
use AppBundle\Domain\Entity\Ticket;
use AppBundle\Domain\Validator\Constraints\IsClosed;
use AppBundle\Domain\Validator\Constraints\IsClosedValidator;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class IsClosedTest extends WebTestCase
{
    private $ticket;

    public function setUp()
    {
        $now = new \DateTime('NOW');
        $birthday = new \DateTime('1991-09-01');
        $entry = new \DateTime('2017-09-02');

        $command = new Command();
        $ticket = new Ticket();

        $ticket->setCommand($command);
        $ticket->setBirthday($birthday);
        $ticket->setCountry('France');
        $ticket->setFirstName('Marc');
        $ticket->setLastName('Arnoult');
        $ticket->setEntryAt($entry);
        $ticket->setReduction(false);
        $ticket->setCreatedAt($now);
        $ticket->setType('Journée');

        $this->ticket = $ticket;
    }

    public function testIsValid()
    {
        $kernel = self::createKernel();
        $kernel->boot();

        $validator = $kernel->getContainer()->get('validator');

        $errors = $validator->validate($this->ticket);
        $this->assertCount(0, $errors);
    }
}
