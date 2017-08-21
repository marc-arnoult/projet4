<?php

namespace AppBundle\Domain\Manager;

use AppBundle\Domain\Entity\Command;
use AppBundle\Domain\Entity\Ticket;
use AppBundle\Domain\Payload\PayloadFactory;
use AppBundle\Domain\Service\PriceCalculatorInterface;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\ValidatorBuilderInterface;

class CommandManager
{
    private $doctrine;
    private $validator;
    private $calculator;
    private $payload;

    public function __construct(
        EntityManagerInterface $doctrine,
        ValidatorBuilderInterface $validator,
        PriceCalculatorInterface $priceCalculator,
        PayloadFactory $payload
    )
    {
        $this->doctrine = $doctrine;
        $this->validator = $validator;
        $this->calculator = $priceCalculator;
        $this->payload = $payload;
    }

    public function createCommand(string $data)
    {
        $content = json_decode($data);
        $now = new \DateTime('NOW');

        $ticketRemaining = $this->doctrine->getRepository('AppBundle:Ticket')->getTicketsRemaining($content->entry_at);

        if (count($content->tickets) > $ticketRemaining) return $this->payload->badRequest(['content' => 'Not enough ticket remaining']);

        $command = new Command();
        $command->setCreatedAt($now);
        $command->setType($content->type);
        $command->setEmail($content->email);
        $totalPrice = 0;

        foreach ($content->tickets as $index => $data) {
            $ticket = new Ticket();
            $ticket->setFirstName($data->first_name);
            $ticket->setReduction($data->reduction);
            $ticket->setLastName($data->last_name);
            $ticket->setBirthday(new \DateTime($data->birthday));
            $ticket->setCountry($data->country);
            $ticket->setEntryAt(new \DateTime($data->entry_at));

            $ticket->setCreatedAt($now);
            $ticket->setCommand($command);
            $command->setEntryAt($ticket->getEntryAt());

            $this->calculator->calculatePrice($ticket);

            $totalPrice += $ticket->getPrice();

            $errors = $this->validator->getValidator()->validate($ticket);

            if (count($errors) != 0) {
                $messages = [];
                foreach ($errors as $error) {
                    $messages[$error->getPropertyPath()] = $error->getMessage();
                    $messages['index'] = $index;
                }

                return $this->payload->badRequest(['content' => $messages]);
            }

            $this->doctrine->persist($ticket);
        }

        $command->setPrice($totalPrice);

        $this->doctrine->flush();

        return $this->payload->created(['content' => 'created']);
    }
}
