<?php


namespace AppBundle\Action\Api;


use AppBundle\Domain\Manager\TicketManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TicketCreateAction
{
    private $manager;

    public function __construct(TicketManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @Route("/api/tickets")
     * @Method("POST")
     * @param Request $request
     * @return Response
     */
    public function __invoke(Request $request)
    {
        $data = $this->manager->addTickets($request->getContent());
        dump($data);die;
        return new Response($data['content']);
    }
}