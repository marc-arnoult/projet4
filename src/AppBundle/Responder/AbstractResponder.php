<?php


namespace AppBundle\Responder;


use AppBundle\Domain\Payload\PayloadInterface;

abstract class AbstractResponder
{
    private $payload;

    public function setPayload(PayloadInterface $payload)
    {
        $this->payload = $payload;
    }

    public function getPayload() : PayloadInterface
    {
        return $this->payload;
    }
}
