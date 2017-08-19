<?php

namespace AppBundle\Action;


use AppBundle\Responder\HomeResponder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeAction
{
    private $responder;

    public function __construct(HomeResponder $responder)
    {
        $this->responder = $responder;
    }

    /**
     * @param Request $request
     * @return Response
     * @Route("/", name="homepage")
     */
    public function __invoke(Request $request)
    {
        return $this->responder->__invoke();
    }
}
