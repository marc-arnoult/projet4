<?php


namespace AppBundle\Domain\Validator\Constraints;


use Symfony\Component\Validator\Constraint;

class isHoliday extends Constraint
{
    public $message = "You can't reserve at this date the museum is closed";
}