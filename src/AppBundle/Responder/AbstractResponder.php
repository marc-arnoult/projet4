<?php


namespace AppBundle\Responder;


use AppBundle\Domain\Payload\PayloadInterface;

abstract class AbstractResponder
{
    private $payload;

    /**
     * @param PayloadInterface $payload
     */
    public function setPayload(PayloadInterface $payload)
    {
        $this->payload = $payload;
    }

    /**
     * @return PayloadInterface
     */
    public function getPayload() : PayloadInterface
    {
        return $this->payload;
    }
}
