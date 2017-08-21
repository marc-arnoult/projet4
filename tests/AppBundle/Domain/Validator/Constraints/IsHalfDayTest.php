<?php

namespace Test\AppBundle\Domain\Validator\Constraints;


use AppBundle\Domain\Entity\Command;
use AppBundle\Domain\Entity\Ticket;
use AppBundle\Domain\Validator\Constraints\IsHalfDay;
use AppBundle\Domain\Validator\Constraints\IsHalfDayValidator;

require_once(__DIR__.'/ValidatorTestAbstract');

class IsHalfDayTest extends ValidatorTestAbstract
{
    /**
     * {@inheritdoc}
     */
    protected function getValidatorInstance()
    {
        return new IsHalfDayValidator();
    }

    public function testIsValid()
    {
        $ticket = new Ticket();
        $command = new Command();

        $command->setType('Demi-journée');
        $ticket->setEntryAt(new \DateTime('NOW'));
        $ticket->setCommand($command);

        $isHalfDayConstraint = new IsHalfDay();
        $validator = $this->initValidator();

        $validator->validate($ticket, $isHalfDayConstraint);
    }

    public function testIsNotValid()
    {
        $ticket = new Ticket();
        $command = new Command();

        $command->setType('Journée');
        $ticket->setEntryAt(new \DateTime('now'));
        $ticket->setCommand($command);

        $isHalfDayConstraint = new IsHalfDay();

        if (date('H', $ticket->getEntryAt()->getTimeStamp()) >= 14 ) {
            $validator = $this->initValidator($isHalfDayConstraint->message);
        } else {
            $validator = $this->initValidator();
        }

        $validator->validate($ticket, $isHalfDayConstraint);
    }
}
