<?php


namespace AppBundle\Domain\Validator\Constraints;


use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class isClosedValidator extends ConstraintValidator
{
    private $closed = ['01/05', '01/11', '25/12', 'Tue', 'Sun'];
    /**
     * Checks if the date is not holiday
     *
     * @param mixed $value The value that should be validated
     * @param Constraint $constraint The constraint for the validation
     */
    public function validate($value, Constraint $constraint)
    {
    }
}
