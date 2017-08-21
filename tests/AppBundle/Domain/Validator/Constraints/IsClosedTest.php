<?php

namespace Test\AppBundle\Domain\Validator\Constraints;


use AppBundle\Domain\Entity\Command;
use AppBundle\Domain\Entity\Ticket;
use AppBundle\Domain\Validator\Constraints\IsClosed;
use AppBundle\Domain\Validator\Constraints\IsClosedValidator;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

require_once(__DIR__.'/ValidatorTestAbstract');

class IsClosedTest extends ValidatorTestAbstract
{
    /**
     * {@inheritdoc}
     */
    protected function getValidatorInstance()
    {
        return new IsClosedValidator();
    }

    public function testIsValid()
    {
        $ticket = new Ticket();
        $command = new Command();

        $command->setType('Journée');
        $ticket->setEntryAt(new \DateTime('2017-11-25'));
        $ticket->setCommand($command);

        $isClosedConstraint = new IsClosed();
        $validator = $this->initValidator();

        $validator->validate($ticket->getEntryAt(), $isClosedConstraint);
    }

    public function testIsNotValid()
    {
        $ticket = new Ticket();
        $command = new Command();

        $command->setType('Journée');
        $ticket->setEntryAt(new \DateTime('2017-12-25'));
        $ticket->setCommand($command);

        $isClosedConstraint = new IsClosed();
        $validator = $this->initValidator($isClosedConstraint->message);

        $validator->validate($ticket->getEntryAt(), $isClosedConstraint);
    }

    public function testGetHolidays()
    {
        $validator = new IsClosedValidator();
        $holidays = $validator->getHolidays();

        $this->assertEquals("01-01-17", date('d-m-y', $holidays[0]));
        $this->assertEquals("01-05-17", date('d-m-y', $holidays[2]));
    }
}
