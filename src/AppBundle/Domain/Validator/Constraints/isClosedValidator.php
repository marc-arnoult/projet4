<?php


namespace AppBundle\Domain\Validator\Constraints;


use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class isClosedValidator extends ConstraintValidator
{
    private $closed = ['Tue', 'Sun'];
    /**
     * Checks if the passed value is valid.
     *
     * @param mixed $value The value that should be validated
     * @param Constraint $constraint The constraint for the validation
     */
    public function validate($value, Constraint $constraint)
    {
        foreach ($this->closed as $dayClosed) {
            if ($dayClosed === date('D', $value->getTimeStamp())) {
                $this->context->buildViolation($constraint->message)
                    ->addViolation();
            }
        }
    }
}