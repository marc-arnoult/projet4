<?php


namespace AppBundle\Domain\Payload;


class Payload implements PayloadInterface
{
    private $payload;

    /**
     * Payload constructor.
     * @param array $payload
     */
    public function __construct(array $payload)
    {
        $this->payload = $payload;
    }

    public function get($key = null)
    {
        if ($key === null) {
            return $this->payload;
        }
        if (isset($this->payload[$key])) {
            return $this->payload[$key];
        }

        return null;
    }
}