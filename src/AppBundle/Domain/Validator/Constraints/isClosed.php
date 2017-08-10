<?php


namespace AppBundle\Domain\Validator\Constraints;


use Symfony\Component\Validator\Constraint;

class isClosed extends Constraint
{
    public $message = "You can't reserve at this date the museum is closed";
}