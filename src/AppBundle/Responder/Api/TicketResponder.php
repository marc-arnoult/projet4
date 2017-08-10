<?php


namespace AppBundle\Responder\Api;

use AppBundle\Responder\AbstractResponder;
use Symfony\Component\HttpFoundation\JsonResponse;

class TicketResponder extends AbstractResponder
{
    /**
     * @param $data
     * @return JsonResponse
     */
    public function __invoke($data)
    {
        return new JsonResponse(json_encode($data['content']), $data['status_code'], [], true);
    }
}
