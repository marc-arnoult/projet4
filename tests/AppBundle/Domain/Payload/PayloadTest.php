<?php

namespace Test\AppBundle\Domain\Payload;


use AppBundle\Domain\Payload\BadRequest;
use AppBundle\Domain\Payload\Created;
use AppBundle\Domain\Payload\Found;
use AppBundle\Domain\Payload\NotFound;
use AppBundle\Domain\Payload\PayloadFactory;
use PHPUnit\Framework\TestCase;

class PayloadTest extends TestCase
{
    public function testFactory()
    {
        $payload = new PayloadFactory();
        $foundPayload = $payload->found([]);
        $createdPayload = $payload->created([]);
        $notFoundPayload = $payload->notFound([]);
        $badRequestPayload = $payload->badRequest([]);

        $this->assertInstanceOf(Found::class, $foundPayload);
        $this->assertInstanceOf(Created::class, $createdPayload);
        $this->assertInstanceOf(NotFound::class, $notFoundPayload);
        $this->assertInstanceOf(BadRequest::class, $badRequestPayload);
    }

    public function testPayload()
    {
        $payload = new PayloadFactory();
        $foundPayload = $payload->found(['content' => 'found']);
        $createdPayload = $payload->created([]);

        $this->assertEquals('found' ,$foundPayload->get('content'));
        $this->assertNull($createdPayload->get('null'));
        $this->assertEmpty($createdPayload->get());
    }
}
