<?php

namespace AppBundle\Domain\Validator\Constraints;


use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class IsHalfDay extends Constraint
{
    public $message = "You can't take a ticket passed 14h";

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
