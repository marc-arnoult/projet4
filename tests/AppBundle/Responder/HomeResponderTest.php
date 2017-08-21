<?php

namespace Tests\AppBundle\Responder;


use AppBundle\Responder\HomeResponder;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Templating\EngineInterface;

class HomeResponderTest extends TestCase
{
    private $twig;

    public function setUp()
    {
        $this->twig = $this->createMock(EngineInterface::class);
    }

    public function testSetData()
    {
        $responder = new HomeResponder($this->twig);
        $responder->setPayload('Hello');

        $this->assertEquals('Hello', $responder->getPayload());
    }
}