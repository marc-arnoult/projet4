<?php


namespace Test\AppBundle\Domain\Service;


use AppBundle\Domain\Entity\Command;
use AppBundle\Domain\Entity\Ticket;
use AppBundle\Domain\Service\TicketSender;
use PHPUnit\Framework\TestCase;
use Swift_MemorySpool;
use Symfony\Component\Templating\EngineInterface;

class SenderTest extends SwiftMailerTestCase
{
    /**
     * @var TicketSender
     */
    private $sender;

    public function testSendEmail()
    {
        $ticket = new Ticket();
        $command = new Command();
        $command->addTicket($ticket);
        $command->setEntryAt(new \DateTime('NOW'));
        $command->setEmail('marc.arnoult@hotmail.fr');

        $this->sender->send($command);

        $this->assertMessageCount(1, 'should have sent one email');

        $msg = $this->getMessages()[0];

        $this->assertArrayHasKey('marc.arnoult@hotmail.fr', $msg->getTo());
    }

    protected function setUp()
    {
        parent::setUp();
        $twig = $this->createMock(EngineInterface::class);
        $this->sender = new TicketSender($this->mailer, $twig);
    }
}


class SwiftMailerTestCase extends TestCase
{
    protected $mailer, $transport, $spool;

    protected function setUp()
    {
        $this->spool = new CountableMemorySpool();
        $this->transport = new \Swift_Transport_SpoolTransport(
            new \Swift_Events_SimpleEventDispatcher(),
            $this->spool
        );
        $this->mailer = new \Swift_Mailer($this->transport);
    }

    protected function assertMessageCount($count, $msg='')
    {
        $this->assertCount($count, $this->spool, $msg);
    }

    protected function getMessages()
    {
        return $this->spool->getMessages();
    }
}

final class CountableMemorySpool extends Swift_MemorySpool implements \Countable
{

    public function count()
    {
        return count($this->messages);
    }

    public function getMessages()
    {
        return $this->messages;
    }
}
