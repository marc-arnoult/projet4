<?php


namespace AppBundle\Domain\Validator\Constraints;


use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class IsClosed extends Constraint
{
    public $message = "You can't reserve this day";
}
