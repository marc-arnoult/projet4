<?php

namespace AppBundle\Domain\Manager;

use AppBundle\Domain\Entity\Command;
use AppBundle\Domain\Entity\Ticket;
use Doctrine\ORM\EntityManagerInterface;

class CommandManager
{
    private $doctrine;

    public function __construct(EntityManagerInterface $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function addCommand($data)
    {
        $command = new Command();
        $command->setCreatedAt(new \DateTime('NOW'));
        $command->setEmail('marc.arnoult@hotmail.fr');
        $command->setType('Journées');
        $tickets = [];

        foreach (json_decode($data) as $item) {
            $ticket = new Ticket();
            $ticket->setFirstName($item->first_name);
            $ticket->setLastName($item->last_name);
            $ticket->setCountry($item->country);
            $ticket->setEntryAt((new \DateTime('NOW')));
            $ticket->setBirthday((new \DateTime('NOW')));
            $ticket->setPrice(12);
            $ticket->setReduction($item->reduction);
            $ticket->setCommand($command);
            array_push($tickets, $ticket);

            $this->doctrine->persist($ticket);
        }

        $this->doctrine->persist($command);
        $this->doctrine->flush();

        return $tickets;
    }
}
