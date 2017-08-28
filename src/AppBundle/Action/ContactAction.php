<?php


namespace AppBundle\Action;


use AppBundle\Domain\Payload\PayloadFactory;
use AppBundle\Domain\Service\ContactSender;
use AppBundle\Responder\ContactResponder;
use AppBundle\Responder\HomeResponder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactAction
{
    private $responder;
    private $sender;
    private $payload;

    public function __construct(ContactResponder $responder, ContactSender $sender, PayloadFactory $payload)
    {
        $this->responder = $responder;
        $this->sender = $sender;
        $this->payload = $payload;
    }

    /**
     * @param Request $request
     * @Route("/api/contact", name="contact")
     * @return Response
     */
    public function __invoke(Request $request)
    {
        $data = json_decode($request->getContent());
        $this->sender->send($data, $data->from);
        $payload = $this->payload->created(['content' => 'Email send']);

        $this->responder->setPayload($payload);
        return $this->responder->__invoke();
    }
}
