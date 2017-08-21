<?php


namespace AppBundle\Domain\Manager;


use AppBundle\Domain\Entity\Ticket;
use AppBundle\Domain\Filter\DateFilterInterface;
use AppBundle\Domain\Service\PriceCalculatorInterface;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\ValidatorBuilderInterface;

/**
 * Class TicketManager
 * @package AppBundle\Domain\Manager
 */
class TicketManager
{
    private $doctrine;
    private $dateFilter;

    public function __construct(
        EntityManagerInterface $doctrine,
        DateFilterInterface $dateFilter
    )
    {
        $this->doctrine = $doctrine;
        $this->dateFilter = $dateFilter;
    }

    public function getTicketsRemaining($day)
    {
        $repository = $this->doctrine->getRepository('AppBundle:Ticket');

        if ($this->dateFilter->isValid($day)) {
            $remaining = $repository->getTicketsRemaining((new \DateTime($day))->format('Y-m-d'));

            return ['content' => $remaining, 'status_code' => JsonResponse::HTTP_OK];
        }

        return ['content' => 'Le champ date doit être correction rempli', 'status_code' => JsonResponse::HTTP_BAD_REQUEST];
    }
}
