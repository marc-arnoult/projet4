<?php

namespace AppBundle\Domain\Manager;

use AppBundle\Domain\Entity\Command;
use AppBundle\Domain\Entity\Ticket;
use AppBundle\Domain\Payload\PayloadFactory;
use AppBundle\Domain\Service\PriceCalculatorInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Validator\ValidatorBuilderInterface;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;

class CommandManager
{
    private $doctrine;
    private $validator;
    private $calculator;
    private $payload;

    public function __construct(
        EntityManagerInterface $doctrine,
        ValidatorBuilderInterface $validator,
        PriceCalculatorInterface $priceCalculator,
        PayloadFactory $payload
    )
    {
        $this->doctrine = $doctrine;
        $this->validator = $validator;
        $this->calculator = $priceCalculator;
        $this->payload = $payload;
    }

    public function createCommand($content)
    {
        $hydrator = new DoctrineHydrator($this->doctrine);

        $ticketRemaining = $this->doctrine->getRepository('AppBundle:Ticket')->getTicketsRemaining($content['entryAt']);

        if (count($content['tickets']) > $ticketRemaining) {
            return $this->payload->badRequest(['content' => 'Not enough ticket remaining']);
        }

        $command = new Command();
        $command->setType($content['type']);
        $command->setEmail($content['email']);
        $command->setEntryAt(new \DateTime($content['entryAt']));

        foreach ($content['tickets'] as $data) {
            $ticket = new Ticket();
            $ticket = $hydrator->hydrate($data, $ticket);
            $ticket->setCommand($command);
        }

        $this->calculator->calculatePriceFromOrder($command);
        $errors = $this->validator->getValidator()->validate($command);

        if (count($errors) > 0) {
            return $this->payload->badRequest(['content' => (string) $errors]);
        }

        $session = new Session();
        $session->set('command', $command);

        return $this->payload->found(['content' => 'found']);
    }
}
