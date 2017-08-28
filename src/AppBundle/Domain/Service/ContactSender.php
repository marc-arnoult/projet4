<?php


namespace AppBundle\Domain\Service;


class ContactSender implements SenderInterface
{
    private $mailer;

    /**
     * TicketSender constructor.
     * @param \Swift_Mailer $mailer
     */
    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * @param $data
     * @param null $from
     * @param null $to
     */
    public function send($data, $from = null, $to = null)
    {
        $message = (new \Swift_Message('Ticket'))
            ->setFrom($from)
            ->setTo('marc.arnoult76@gmail.com')
            ->setBody($data->message, 'text/plain');

        $this->mailer->send($message);
    }
}