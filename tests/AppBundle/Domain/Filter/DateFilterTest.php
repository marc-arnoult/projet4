<?php


namespace Test\AppBundle\Domain\Filter;


use AppBundle\Domain\Filter\DateFilter;
use PHPUnit\Framework\TestCase;

class DateFilterTest extends TestCase
{
    public function testIsValid()
    {
        $dateFilter = new DateFilter();
        $this->assertTrue($dateFilter->isValid('2017-08-08'));
    }

    public function testIsNotValid()
    {
        $dateFilter = new DateFilter();
        $this->assertFalse($dateFilter->isValid('2017-08-08--1'));
        $this->assertFalse($dateFilter->isValid('2017-08'));
        $this->assertFalse($dateFilter->isValid(1));
    }
}
