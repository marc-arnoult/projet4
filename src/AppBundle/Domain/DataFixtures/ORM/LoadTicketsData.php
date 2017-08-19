<?php
namespace AppBundle\Domain\DataFixtures\ORM;

use AppBundle\Domain\Entity\Command;
use AppBundle\Domain\Entity\Ticket;
use AppBundle\Domain\Service\PriceCalculator;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class LoadTicketsData
 * @package AppBundle\DataFixtures\ORM
 *
 * @codeCoverageIgnore
 */
class LoadTicketsData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $command = new Command();
        $ticket = new Ticket();

        $ticket->setCreatedAt(new \DateTime('NOW'));
        $ticket->setEntryAt(new \DateTime('2017-09-09'));
        $ticket->setReduction(false);
        $ticket->setLastName('Arnoult');
        $ticket->setFirstName('Marc');
        $ticket->setCountry('France');
        $ticket->setBirthday(new \DateTime('1991-09-01'));
        $ticket->setType("Journée");
        $ticket->setPrice(16);

        $command->setEmail('marc.arnoult@hotmail.fr');
        $command->setPrice(16);
        $command->setCreatedAt(new \DateTime('NOW'));
        $command->setType($ticket->getType());

        $ticket->setCommand($command);

        $manager->persist($ticket);
        $manager->flush();
    }
}
