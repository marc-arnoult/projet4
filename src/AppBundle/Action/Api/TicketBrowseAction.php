<?php

namespace AppBundle\Action\Api;


use AppBundle\Domain\Manager\TicketManager;
use AppBundle\Responder\Api\TicketResponder;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class TicketBrowseAction
{
    private $responder;
    private $manager;

    /**
     * TicketBrowseAction constructor.
     * @param TicketResponder $responder
     * @param TicketManager $manager
     * @internal param SerializerInterface $serializer
     */
    public function __construct(TicketResponder $responder, TicketManager $manager)
    {
        $this->responder = $responder;
        $this->manager = $manager;;
    }

    /**
     *
     * @Method("GET")
     * @Route("api/ticket")
     */
    public function __invoke(Request $request)
    {
        $day = $request->query->get('day');
        $data = $this->manager->getTicketsRemaining($day);

        return $this->responder->__invoke($data);
    }
}
