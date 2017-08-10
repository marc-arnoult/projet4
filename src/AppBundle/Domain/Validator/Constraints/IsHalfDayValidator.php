<?php


namespace AppBundle\Domain\Validator\Constraints;


use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class IsHalfDayValidator extends ConstraintValidator
{
    /**
     * Checks if the passed value is valid.
     *
     * @param mixed $ticket
     * @param Constraint $constraint The constraint for the validation
     * @codeCoverageIgnore
     */
    public function validate($ticket, Constraint $constraint)
    {
        $now = (new \DateTime('NOW'))->getTimeStamp();
        $type = $ticket->getType();
        $entry = $ticket->getEntryAt()->getTimeStamp();

        if (
            $type == 'Journée' &&
            date('H', $now) > 14 &&
            date('Ymd') === date('Ymd', $entry)
        )
        {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}