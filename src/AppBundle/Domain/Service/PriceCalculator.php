<?php

namespace AppBundle\Domain\Service;


use AppBundle\Domain\Entity\Ticket;

class PriceCalculator implements PriceCalculatorInterface
{
    const FREE   = 0;
    const CHILD  = 8;
    const ADULT  = 16;
    const PROMO  = 10;
    const SENIOR = 12;

    /**
     * Calculate the price of the ticket from is age ( return nothing the object is passed by reference ).
     *
     * @param Ticket $ticket
     * @return void
     */
    public function calculatePrice(Ticket $ticket) : void
    {
        $age = $this->calculateAge($ticket->getBirthday());

        if ($ticket->getReduction()) {
            $ticket->setPrice(PriceCalculator::PROMO);
        } else {
            switch ($age) {
                case ($age < 4):
                    $ticket->setPrice(PriceCalculator::FREE);
                    break;
                case ($age >= 4 && $age < 12):
                    $ticket->setPrice(PriceCalculator::CHILD);
                    break;
                case ($age >= 60):
                    $ticket->setPrice(PriceCalculator::SENIOR);
                    break;
                default:
                    $ticket->setPrice(PriceCalculator::ADULT);
                    break;
            }
        }
    }


    /**
     * Calculate the age from the birthday.
     *
     * @param \DateTime $birthday
     * @return int
     */
    public function calculateAge(\DateTime $birthday) : int
    {
        return (int) $birthday->diff(new \DateTime('NOW'))->y;
    }
}
