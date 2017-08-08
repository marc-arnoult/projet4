<?php


namespace AppBundle\Responder\Api;


use Symfony\Component\HttpFoundation\JsonResponse;

class CommandResponder
{
    public function __invoke($data)
    {
        return new JsonResponse(json_encode(['Created' => 'yeah']), $data, [], true);
    }
}