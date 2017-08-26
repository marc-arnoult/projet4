<?php


namespace AppBundle\Domain\EventListener;


use AppBundle\Domain\Entity\Command;
use AppBundle\Domain\Service\TicketSender;
use Doctrine\ORM\Event\LifecycleEventArgs;

class CommandListener
{
    private $sender;

    public function __construct(TicketSender $sender)
    {
        $this->sender = $sender;
    }

    public function postPersist(LifecycleEventArgs $args)
    {
        $command = $args->getObject();

        if (!$command instanceof Command) {
            return;
        }

        $this->sender->send($command);
    }
}
