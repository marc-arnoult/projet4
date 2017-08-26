<?php


namespace AppBundle\Domain\Service;


interface SenderInterface
{
    public function send($data, $from = null, $to = null);
}
