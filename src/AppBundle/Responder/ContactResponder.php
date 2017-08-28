<?php


namespace AppBundle\Responder;


use Symfony\Component\HttpFoundation\JsonResponse;

class ContactResponder extends AbstractResponder
{
    public function __invoke()
    {
        $payload = $this->getPayload();
        $content = $payload->get('content');

        return new JsonResponse($content, $payload->status);
    }
}