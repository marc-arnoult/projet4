<?php


namespace AppBundle\Responder\Api;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TicketResponder
{
    /**
     * @param $data
     * @return JsonResponse
     */
    public function __invoke($data)
    {
        return new JsonResponse($data, 200, [], true);
    }
}
