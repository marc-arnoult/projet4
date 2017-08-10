<?php


namespace AppBundle\Domain\Validator\Constraints;


use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class IsHolidayValidator extends ConstraintValidator
{
    private $closed = ['01/05', '01/11', '25/12'];
    /**
     * Checks if the date is not holiday
     *
     * @param mixed $value The value that should be validated
     * @param Constraint $constraint The constraint for the validation
     */
    public function validate($value, Constraint $constraint)
    {
        foreach ($this->closed as $dayClosed) {
            if ($dayClosed === $value->format('d/m')) {
                $this->context->buildViolation($constraint->message)
                    ->addViolation();
            }
        }
    }
}
