<?php

namespace Test\AppBundle\Domain\Entity;


use AppBundle\Domain\Entity\Command;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class CommandTest extends WebTestCase
{
    public function testCommand()
    {
        $command = new Command();
        $command->setEmail('marc.arnoult@hotmail.fr');
        $command->setType('Journée');

        $date = new \DateTime('NOW');
        $command->setCreatedAt($date);

        $this->assertEquals('marc.arnoult@hotmail.fr', $command->getEmail());
        $this->assertEquals('Journée', $command->getType());
        $this->assertEquals($date, $command->getCreatedAt());
        $this->assertEquals(null, $command->getId());
    }
}
