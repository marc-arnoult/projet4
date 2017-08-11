<?php


namespace AppBundle\Domain\Filter;

/**
 * Class DateFilter
 * @package AppBundle\Domain\Filter
 */
class DateFilter implements DateFilterInterface
{
    /**
     * @param string $value
     * @return bool
     */
    public function isValid($value) : bool
    {
        if (!strtotime($value)) {
            return false;
        }

        $date = explode('-', $value);

        if (count($date) > 2) {
            list($y, $m, $d) = $date;
            return checkdate($m, $d, $y);
        }

        return false;
    }
}
