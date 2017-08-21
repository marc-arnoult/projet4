<?php

namespace Test\AppBundle\Domain\Validator\Constraints;


use AppBundle\Domain\Entity\Command;
use AppBundle\Domain\Entity\Ticket;
use AppBundle\Domain\Validator\Constraints\IsClosed;
use AppBundle\Domain\Validator\Constraints\IsClosedValidator;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

require_once(__DIR__.'/ValidatorTestAbstract');

class IsClosedTest extends WebTestCase
{
    public function testIs()
    {
        $this->assertEquals(1, 1);
    }
}
