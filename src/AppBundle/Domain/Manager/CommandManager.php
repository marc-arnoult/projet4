<?php

namespace AppBundle\Domain\Manager;

use AppBundle\Domain\Entity\Command;
use AppBundle\Domain\Entity\Ticket;
use AppBundle\Domain\Service\PriceCalculator;
use AppBundle\Domain\Service\PriceCalculatorInterface;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\ValidatorBuilderInterface;

class CommandManager
{
    private $doctrine;
    private $validator;
    private $serializer;
    private $calculator;

    public function __construct(
        EntityManagerInterface $doctrine,
        ValidatorBuilderInterface $validator,
        SerializerInterface $serializer,
        PriceCalculatorInterface $calculator
    )
    {
        $this->doctrine = $doctrine;
        $this->validator = $validator;
        $this->serializer = $serializer;
        $this->calculator = $calculator;
    }

    public function createCommand($data)
    {
        $totalPrice = 0;
        $tickets = $this->serializer->deserialize($data, 'array<AppBundle\\Domain\\Entity\\Ticket>', 'json');

        $command = new Command();
        $command->setCreatedAt(new \DateTime('NOW'));
        $command->setEmail('marc.arnoult@hotmail.fr');

        foreach ($tickets as $index => $ticket) {
            $ticket->setCreatedAt($command->getCreatedAt());
            $ticket->setCommand($command);
            $command->setType($ticket->getType());

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

            $totalPrice += $ticket->getPrice();

            $this->doctrine->persist($ticket);
        }

        $command->setPrice($totalPrice);
        $this->doctrine->flush();

        return ['content' => 'created', 'status_code' => JsonResponse::HTTP_CREATED];
    }
}
