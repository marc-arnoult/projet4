<?php

namespace Test\AppBundle\Domain\Payload;


use AppBundle\Domain\Payload\Payload;
use PHPUnit\Framework\TestCase;

class PayloadTest extends TestCase
{
    public function testSetData()
    {
        $payload = new Payload(['status_code' => 200]);

        $this->assertEquals(200, $payload->get('status_code'));
        $this->assertNull($payload->get('random'));
    }
}
