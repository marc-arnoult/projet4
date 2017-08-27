<?php

namespace AppBundle\Domain\Repository;
use AppBundle\Domain\Entity\{
    Ticket
};

/**
 * TicketRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TicketRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * Return the number of ticket remaining for the day passed in the parameter.
     *
     * @param $date
     * @return int
     */
    public function getTicketsRemaining($date)
    {
        return Ticket::TICKET_LIMIT - $this->createQueryBuilder('t')
                ->select('COUNT(t)')
                ->where("t.entryAt LIKE :day")
                ->setParameter(':day', "$date%")
                ->getQuery()
                ->getSingleScalarResult();
    }
}
