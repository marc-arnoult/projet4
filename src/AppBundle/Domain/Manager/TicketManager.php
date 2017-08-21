<?php


namespace AppBundle\Domain\Manager;


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
    private $serializer;
    private $validator;
    private $calculator;

    public function __construct(
        EntityManagerInterface $doctrine,
        DateFilterInterface $dateFilter,
        SerializerInterface $serializer,
        ValidatorBuilderInterface $validator,
        PriceCalculatorInterface $priceCalculator
    )
    {
        $this->doctrine = $doctrine;
        $this->dateFilter = $dateFilter;
        $this->validator = $validator;
        $this->serializer = $serializer;
        $this->calculator = $priceCalculator;
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

    public function addTickets($data)
    {
        $tickets = $this->serializer->deserialize($data, 'array<AppBundle\\Domain\\Entity\\Ticket>', 'json');
        $now = new \DateTime('NOW');

        foreach ($tickets as $index => $ticket) {
            $ticket->setCreatedAt($now);

            $this->calculator->calculatePrice($ticket);

            $errors = $this->validator->getValidator()->validate($ticket);

            if (count($errors) != 0) {
                $messages = [];
                foreach ($errors as $error) {
                    $messages[$error->getPropertyPath()] = $error->getMessage();
                    $messages['index'] = $index;
                }
                return ['content' => $messages, 'status_code' => JsonResponse::HTTP_BAD_REQUEST];
            }

            $this->doctrine->persist($ticket);
        }

        $this->doctrine->flush();
        return ['content' => 'created', 'status_code' => JsonResponse::HTTP_CREATED];
    }
}
