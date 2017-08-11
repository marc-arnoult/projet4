<?php


namespace AppBundle\Domain\Service;


interface PriceCalculatorInterface
{
    public function calculate($data) : int;
}
