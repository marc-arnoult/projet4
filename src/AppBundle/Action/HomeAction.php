<?php

namespace AppBundle\Action;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Templating\EngineInterface;

class HomeAction
{
    private $twig;

    public function __construct(EngineInterface $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @return Response
     *
     * @Route("/", name="homepage")
     */
    public function __invoke()
    {
        return new Response($this->twig->render(':default:index.html.twig'));
    }
}