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

    public function __construct(
        EntityManagerInterface $doctrine,
        ValidatorBuilderInterface $validator,
        SerializerInterface $serializer
    )
    {
        $this->doctrine = $doctrine;
        $this->validator = $validator;
        $this->serializer = $serializer;
    }

    public function createCommand($data)
    {
        $command = $this->serializer->deserialize($data, Command::class, 'json');
        $command->setCreatedAt(new \DateTime('NOW'));

        $errors = $this->validator->getValidator()->validate($command);

        if (count($errors) !== 0) {
            $messages = [];

            foreach ($errors as $error) {
                $messages[$error->getPropertyPath()] = $error->getMessage();
            }

            return ['content' => $messages, 'status_code' => JsonResponse::HTTP_BAD_REQUEST];
        }

        $this->doctrine->persist($command);
        $this->doctrine->flush();

        return ['content' => "Created " . $command->getId(), 'status_code' => JsonResponse::HTTP_CREATED];
    }
}
