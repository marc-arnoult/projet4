<?php

namespace Test\AppBundle\Domain\Payload;


use AppBundle\Domain\Payload\AbstractPayload;
use PHPUnit\Framework\TestCase;

class PayloadTest extends TestCase
{
    public function testSetData()
    {
        $payload = new AbstractPayload(['status_code' => 200]);

        $this->assertEquals(200, $payload->get('status_code'));
        $this->assertNull($payload->get('random'));
        $this->assertEquals(['status_code' => 200], $payload->get());
    }
}
