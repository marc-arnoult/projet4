<?php


namespace AppBundle\Domain\Manager;


use AppBundle\Domain\Entity\Ticket;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class TicketManager
{
    private $doctrine;
    private $request;
    private $serializer;

    public function __construct(
        EntityManagerInterface $doctrine,
        RequestStack $request,
        SerializerInterface $serializer)
    {
        $this->doctrine = $doctrine;
        $this->request = $request;
        $this->serializer = $serializer;
    }

    public function getTickets()
    {
        $repository = $this->doctrine->getRepository('AppBundle:Ticket');

        if ($date = $this->request->getCurrentRequest()->get('day')) {
            $day = new \DateTime($date);
            $ticketSold = $repository->getTicketByDay($day->format('Y-m-d'));

            $data = ['ticket_remaining' => (Ticket::TICKET_LIMIT - $ticketSold)];

            return $this->serializer->serialize($data, 'json');
        }

        $data = $repository->findAll();

        return $this->serializer->serialize($data, 'json');
    }
}
