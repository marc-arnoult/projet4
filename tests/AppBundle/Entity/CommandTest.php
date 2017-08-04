<?php

namespace Test\AppBundle\Entity;


use AppBundle\Entity\Command;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class CommandTest extends WebTestCase
{
    public function test_create_command()
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
