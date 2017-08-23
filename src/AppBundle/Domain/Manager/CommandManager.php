<?php

namespace AppBundle\Domain\Manager;

use AppBundle\Domain\Entity\Command;
use AppBundle\Domain\Entity\Ticket;
use AppBundle\Domain\Payload\PayloadFactory;
use AppBundle\Domain\Service\PriceCalculatorInterface;
use Doctrine\ORM\EntityManagerInterface;
use Stripe\Charge;
use Stripe\Stripe;
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
            $ticket->setEntryAt($command->getEntryAt());
        }

        $this->calculator->calculatePriceFromCommand($command);
        $errors = $this->validator->getValidator()->validate($command);

        if (count($errors) > 0) {
            return $this->payload->badRequest(['content' => (string) $errors]);
        }

        $session = new Session();
        $session->set('command', $command);

        $message = ['content' => [
                'price' => $command->getPrice(),
                'started' => true
            ]
        ];

        return $this->payload->found($message);
    }

    public function payment($token)
    {
        $session = new Session();
        $command = $session->get('command');

        Stripe::setApiKey("sk_test_ZejfvxMqrtcsR2P4A09QKR0i");

        $response = Charge::create([
            'amount' => $command->getPrice() * 100,
            'currency' => 'eur',
            'source' => $token,
            'description' => 'Ticketing, Museum of louvre',
        ]);


    }
}
