<?php
namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Command;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Ticket;

class LoadTicketsData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $command = new Command();
        $command->setCreatedAt(new \DateTime('NOW'));
        $command->setType('Journée');
        $command->setEmail('marc.arnoult@hotmail.fr');

        $manager->persist($command);

        for ($i = 0; $i < 10; $i++) {
            $ticket = new Ticket();
            $ticket->setEntryAt(new \DateTime('2017-09-09'));
            $ticket->setReduction(false);
            $ticket->setPrice(16);
            $ticket->setLastName('Arnoult');
            $ticket->setFirstName('Marc');
            $ticket->setCountry('France');
            $ticket->setBirthday(new \DateTime('1991-09-01'));
            $ticket->setCreatedAt(new \DateTime('NOW'));
            $ticket->setCommand($command);
            $manager->persist($ticket);
        }

        $manager->flush();
    }
}