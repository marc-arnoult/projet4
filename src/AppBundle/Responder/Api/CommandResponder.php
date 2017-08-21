<?php


namespace AppBundle\Responder\Api;


use AppBundle\Responder\AbstractResponder;
use Symfony\Component\HttpFoundation\JsonResponse;

class CommandResponder extends AbstractResponder
{
    public function __invoke()
    {
        $payload = $this->getPayload();

        $response = new JsonResponse();
        $response->setData($payload->get('content'));
        $response->setStatusCode($payload->status);

        return $response;
    }
}
