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

    public function getTicketsRemaining()
    {
        $repository = $this->doctrine->getRepository('AppBundle:Ticket');
        $date = $this->request->getCurrentRequest()->get('day');

        if ($this->dateFilter->isValid($date)) {
            $day = new \DateTime($date);
            $remaining = $repository->getTicketsRemaining($day->format('Y-m-d'));

            $data = ['content' => $remaining, 'status_code' => JsonResponse::HTTP_OK];

            return $data;
        }

        return ['content' => 'Le champ date doit être correction rempli', 'status_code' => JsonResponse::HTTP_BAD_REQUEST];
    }
}
