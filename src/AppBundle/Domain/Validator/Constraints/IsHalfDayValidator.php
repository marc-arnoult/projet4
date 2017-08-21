<?php


namespace AppBundle\Domain\Validator\Constraints;


use AppBundle\Domain\Entity\Command;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class IsHalfDayValidator extends ConstraintValidator
{
    /**
     * Checks if the passed value is valid.
     *
     * @param mixed $ticket
     * @param Constraint $constraint The constraint for the validation
     */
    public function validate($ticket, Constraint $constraint)
    {
        $today = (new \DateTime('NOW'))->getTimeStamp();

        if (
            date('H', $today) >= 14 &&
            date('d/m/y', $today) === date('d/m/y', $ticket->getEntryAt()->getTimeStamp()) &&
            $ticket->getCommand()->getType() === Command::DAY
        )
        {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}
