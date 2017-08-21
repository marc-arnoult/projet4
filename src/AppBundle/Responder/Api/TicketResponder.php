<?php


namespace AppBundle\Responder\Api;

use AppBundle\Domain\Payload\PayloadInterface;
use AppBundle\Responder\AbstractResponder;
use Symfony\Component\HttpFoundation\JsonResponse;

class TicketResponder extends AbstractResponder
{
    /**
     * @return JsonResponse
     */
    public function __invoke()
    {
        $payload = $this->getPayload();

        $response = new JsonResponse();
        $response->setData($payload->get('content'));
        $response->setStatusCode($payload->status);

        return $response;
    }
}
