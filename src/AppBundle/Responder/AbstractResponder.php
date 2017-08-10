<?php


namespace AppBundle\Responder;


abstract class AbstractResponder
{
    private $data;

    public function setData($data)
    {
        $this->data = $data;
    }

    public function getData()
    {
        return $this->data;
    }
}
