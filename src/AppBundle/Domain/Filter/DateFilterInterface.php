<?php


namespace AppBundle\Domain\Filter;

/**
 * Interface DateFilterInterface
 * @package AppBundle\Domain\Filter
 */
interface DateFilterInterface
{
    public function isValid($value) : bool;
}
