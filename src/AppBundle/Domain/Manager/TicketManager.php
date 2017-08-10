<?php


namespace AppBundle\Domain\Manager;


use AppBundle\Domain\Entity\Ticket;
use AppBundle\Domain\Filter\DateFilterInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class TicketManager
 * @package AppBundle\Domain\Manager
 */
class TicketManager
{
    private $doctrine;
    private $request;
    private $dateFilter;

    public function __construct(
        EntityManagerInterface $doctrine,
        RequestStack $request,
        DateFilterInterface $dateFilter
    )
    {
        $this->doctrine = $doctrine;
        $this->request = $request;
        $this->dateFilter = $dateFilter;
    }

    public function getTickets()
    {
        $repository = $this->doctrine->getRepository('AppBundle:Ticket');
        $date = $this->request->getCurrentRequest()->get('day');

        if (!empty($date) && $this->dateFilter->isValid($date)) {
            $day = new \DateTime($date);
            $ticketSold = $repository->getTicketByDay($day->format('Y-m-d'));

            $data = [
                'content' => (Ticket::TICKET_LIMIT - $ticketSold),
                'status_code' => JsonResponse::HTTP_OK,
            ];

            return $data;
        }

        return ['content' => 'You should fill the day parameter', 'status_code' => JsonResponse::HTTP_BAD_REQUEST];
    }
}
