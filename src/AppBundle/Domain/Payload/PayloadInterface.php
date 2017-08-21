<?php


namespace AppBundle\Domain\Payload;


interface PayloadInterface
{
    public function get($key = null);
}
