<?php


namespace AppBundle\Domain\Payload;


class PayloadFactory
{
    public function created(array $data)
    {
        return new Created($data);
    }

    public function badRequest(array $data)
    {
        return new BadRequest($data);
    }

    public function found(array $data)
    {
        return new Found($data);
    }

    public function notFound(array $data)
    {
        return new NotFound($data);
    }
}
