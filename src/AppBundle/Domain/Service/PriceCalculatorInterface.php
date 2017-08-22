<?php


namespace AppBundle\Domain\Service;


use AppBundle\Domain\Entity\Command;

interface PriceCalculatorInterface
{
    public function calculatePriceFromOrder(Command $command) : void;
    public function calculateAge(\DateTime $birthday) : int;
}
