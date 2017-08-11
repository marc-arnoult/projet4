<?php

namespace AppBundle\Domain\Service;


class PriceCalculator implements PriceCalculatorInterface
{
    const CHILD = 8;
    const ADULT = 16;
    const SENIOR = 12;
    const PROMO = 10;

    private $price;

    public function calculate($tickets) : int
    {
        foreach ($tickets as $ticket) {
            $age = (int) $ticket->getBirthday()->diff(new \DateTime('now'))->y;

            if ($ticket->getReduction()) {
                $this->price += PriceCalculator::PROMO;
                break;
            }

            switch ($age) {
                case ($age < 4):
                    $this->price += 0;
                    break;
                case ($age >= 4 && $age < 12):
                    $this->price += PriceCalculator::CHILD;
                    break;
                case ($age >= 60):
                    $this->price += PriceCalculator::SENIOR;
                    break;
                default:
                    $this->price += PriceCalculator::ADULT;
                    break;
            }
        }
        return $this->price;
    }
}
