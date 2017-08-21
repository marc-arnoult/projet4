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
        $command->setEmail('marc.arnoult@hotmail.fr');
        $command->setPrice(16);
        $command->setCreatedAt(new \DateTime('NOW'));
        $command->setEntryAt(new \DateTime('2017-08-20'));
        $command->setType('Journée');

        for ($i = 0; $i < 10; $i++) {
            $ticket = new Ticket();
            $ticket->setReduction(false);
            $ticket->setCreatedAt(new \DateTime('NOW'));
            $ticket->setLastName('Arnoult');
            $ticket->setFirstName('Marc');
            $ticket->setCountry('France');
            $ticket->setBirthday(new \DateTime('1991-09-01'));
            $ticket->setPrice(16);
            $ticket->setCommand($command);
            $ticket->setEntryAt($command->getEntryAt());
            $manager->persist($ticket);
        }

        $manager->flush();
    }
}
