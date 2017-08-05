<?php

namespace AppBundle\Action;


use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;

class SetLocaleAction
{
    private $router;
    private $session;

    /**
     * SetLocaleAction constructor.
     * @param RouterInterface $router
     * @param SessionInterface $session
     */
    public function __construct(RouterInterface $router, SessionInterface $session)
    {
        $this->router = $router;
        $this->session = $session;
    }

    /**
     * @Route("/setLocale/{language}", name="set_locale")
     * @param Request $request
     * @param $language
     * @return RedirectResponse
     */
    public function __invoke(Request $request, string $language)
    {
        $url = $request->headers->get('referer');

        if ($language !== null) {
            $this->session->set('_locale', $language);
        }

        if (empty($url)) {
            $url = $this->router->generate('homepage');
        }

        return new RedirectResponse($url);
    }
}
