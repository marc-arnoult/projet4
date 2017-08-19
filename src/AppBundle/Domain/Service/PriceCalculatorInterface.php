<?php


namespace AppBundle\Domain\Service;


use AppBundle\Domain\Entity\Ticket;

interface PriceCalculatorInterface
{
    public function calculatePrice(Ticket $ticket) : void;
    public function calculateAge(\DateTime $birthday) : int;
}
