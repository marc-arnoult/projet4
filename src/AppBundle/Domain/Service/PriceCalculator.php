<?php

namespace AppBundle\Domain\Service;


class PriceCalculator implements PriceCalculatorInterface
{
    const CHILD = 8;
    const ADULT = 16;
    const SENIOR = 12;
    const PROMO = 10;

    public function calculate($tickets) : int
    {
        $price = 0;

        foreach ($tickets as $ticket) {
            $age = (int) $ticket->getBirthday()->diff(new \DateTime('now'))->y;

            // TODO: Mettre la promo pour les ticket standard et senior
            if ($ticket->getReduction()) {
                $price += PriceCalculator::PROMO;
                break;
            }

            switch ($age) {
                case ($age < 4):
                    $price += 0;
                    break;
                case ($age >= 4 && $age < 12):
                    $price += PriceCalculator::CHILD;
                    break;
                case ($age >= 60):
                    $price += PriceCalculator::SENIOR;
                    break;
                default:
                    $price += PriceCalculator::ADULT;
                    break;
            }
        }
        return $price;
    }
}
