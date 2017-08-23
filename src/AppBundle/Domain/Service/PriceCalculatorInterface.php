<?php


namespace AppBundle\Domain\Service;


use AppBundle\Domain\Entity\Command;

interface PriceCalculatorInterface
{
    public function calculatePriceFromCommand(Command $command) : void;
    public function calculateAge(\DateTime $birthday) : int;
}
