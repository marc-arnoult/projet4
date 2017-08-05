<?php

namespace AppBundle\Action;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Templating\EngineInterface;
use Symfony\Component\Translation\TranslatorInterface;

class HomeAction
{
    private $twig;
    private $translator;

    public function __construct(EngineInterface $twig, TranslatorInterface $translator)
    {
        $this->translator = $translator;
        $this->twig = $twig;
    }

    /**
     * @param Request $request
     * @return Response
     * @Route("/", name="homepage")
     */
    public function __invoke(Request $request)
    {
        return new Response($this->twig->render(':default:index.html.twig'));
    }
}