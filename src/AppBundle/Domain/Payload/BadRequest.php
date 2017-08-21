<?php


namespace AppBundle\Domain\Payload;


class BadRequest extends AbstractPayload
{
    public $status = 400;
}
