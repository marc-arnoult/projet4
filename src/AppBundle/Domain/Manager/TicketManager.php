<?php


namespace AppBundle\Domain\Manager;


use AppBundle\Domain\Entity\Ticket;
use AppBundle\Domain\Filter\DateFilterInterface;
use AppBundle\Domain\Payload\PayloadFactory;
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
    private $payload;

    public function __construct(
        EntityManagerInterface $doctrine,
        DateFilterInterface $dateFilter,
        PayloadFactory $payloadFactory
    )
    {
        $this->doctrine = $doctrine;
        $this->dateFilter = $dateFilter;
        $this->payload = $payloadFactory;
    }

    public function getTicketsRemaining($day)
    {
        $repository = $this->doctrine->getRepository('AppBundle:Ticket');

        if ($this->dateFilter->isValid($day)) {
            $remaining = $repository->getTicketsRemaining((new \DateTime($day))->format('Y-m-d'));

            if (is_null($remaining)) return $this->payload->notFound(['content' => 'Not found']);

            return $this->payload->found(['content' => $remaining]);
        }

        return $this->payload->badRequest(['content' => 'There is an error in your request']);
    }
}
