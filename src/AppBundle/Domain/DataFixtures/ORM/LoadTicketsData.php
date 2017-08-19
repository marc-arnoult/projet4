<?php
namespace AppBundle\Domain\DataFixtures\ORM;

use AppBundle\Domain\Entity\Command;
use AppBundle\Domain\Entity\Ticket;
use AppBundle\Domain\Service\PriceCalculator;
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
        $tickets = [];
        $calculator = new PriceCalculator();

        $command = new Command();
        $command->setCreatedAt(new \DateTime('NOW', new \DateTimeZone("Europe/Paris")));
        $command->setEmail('marc.arnoult@hotmail.fr');

        for ($i = 0; $i < 10; $i++) {
            $ticket = new Ticket();
            $ticket->setCreatedAt(new \DateTime('NOW'));
            $ticket->setEntryAt(new \DateTime('2017-09-09'));
            $ticket->setReduction(false);
            $ticket->setLastName('Arnoult');
            $ticket->setFirstName('Marc');
            $ticket->setCountry('France');
            $ticket->setBirthday(new \DateTime('1991-09-01'));
            $ticket->setCommand($command);
            $ticket->setType("Journée");
            $ticket->setPrice(16);
            array_push($tickets, $ticket);
            $command->setType($ticket->getType());
            $manager->persist($ticket);
        }
        $price = $calculator->calculate($tickets);
        $command->setPrice($price);
        $manager->persist($command);

        $manager->flush();
    }
}
