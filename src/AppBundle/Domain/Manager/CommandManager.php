<?php

namespace AppBundle\Domain\Manager;

use AppBundle\Domain\Entity\Command;
use AppBundle\Domain\Entity\Ticket;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class CommandManager
{
    private $doctrine;

    public function __construct(EntityManagerInterface $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function createCommand($data)
    {
        $command = new Command();
        $tickets = [];

        $command->setCreatedAt(new \DateTime('NOW'));
        $command->setEmail('marc.arnoult@hotmail.fr');

        foreach (json_decode($data) as $item) {
            $command->setType($item->type);

            $ticket = new Ticket();
            $ticket->setFirstName($item->firstName);
            $ticket->setLastName($item->lastName);
            $ticket->setCountry($item->country);
            $ticket->setEntryAt(new \DateTime($item->entryAt));
            $ticket->setBirthday(new \DateTime($item->birthday));
            $ticket->setPrice(12);
            $ticket->setReduction($item->reduction);
            $ticket->setCommand($command);
            array_push($tickets, $ticket);

            $this->doctrine->persist($ticket);
        }

        $this->doctrine->persist($command);
        $this->doctrine->flush();

        return JsonResponse::HTTP_CREATED;
    }
}
