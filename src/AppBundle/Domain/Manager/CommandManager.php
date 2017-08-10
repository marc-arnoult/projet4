<?php

namespace AppBundle\Domain\Manager;

use AppBundle\Domain\Entity\Command;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\ValidatorBuilderInterface;

class CommandManager
{
    private $doctrine;
    private $validator;
    private $serializer;

    public function __construct(EntityManagerInterface $doctrine, ValidatorBuilderInterface $validator,  SerializerInterface $serializer)
    {
        $this->doctrine = $doctrine;
        $this->validator = $validator;
        $this->serializer = $serializer;
    }

    public function createCommand($data)
    {
        $command = new Command();
        $command->setCreatedAt(new \DateTime('NOW'));
        $command->setEmail('marc.arnoult@hotmail.fr');
        $command->setType('Journées');

        $this->doctrine->persist($command);

        $tickets = $this->serializer->deserialize($data, 'array<AppBundle\\Domain\\Entity\\Ticket>', 'json');

        foreach ($tickets as $index => $ticket) {
            $ticket->setCreatedAt(new \DateTime('NOW', new \DateTimeZone("Europe/Paris")));
            $ticket->setCommand($command);

            $errors = $this->validator->getValidator()->validate($ticket);
            if (count($errors) != 0) {
                $messages = [];
                foreach ($errors as $error) {
                    $messages[$error->getPropertyPath()] = $error->getMessage();
                    $messages['index'] = $index;
                }
                return ['content' => $messages, 'status_code' => JsonResponse::HTTP_BAD_REQUEST];
            }

            $this->doctrine->persist($ticket);
        }

        $this->doctrine->flush();

        return ['content' => 'created', 'status_code' => JsonResponse::HTTP_CREATED];
    }
}
