<?php


namespace AppBundle\Domain\Service;


interface SenderInterface
{
    public function send($data);
}