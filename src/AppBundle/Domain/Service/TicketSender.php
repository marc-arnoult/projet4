<?php


namespace AppBundle\Domain\Service;


use Symfony\Component\Templating\EngineInterface;

class TicketSender
{
    private $mailer;
    private $twig;

    public function __construct(\Swift_Mailer $mailer, EngineInterface $twig)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
    }

    public function send($data)
    {
        $numCommand = (string) $data->getId();
        $numCommand .= $data->getEntryAt()->format('dmy');

        $message = (new \Swift_Message('Ticket'))
            ->setFrom('marc.arnoult76@gmail.com')
            ->setTo($data->getEmail())
            ->setBody(
                $this->twig->render(
                    'Emails/registration.html.twig', [
                        'command' => $data,
                        'numCommand' => $numCommand
                    ]),
                'text/html'
            );

        $this->mailer->send($message);
    }
}
