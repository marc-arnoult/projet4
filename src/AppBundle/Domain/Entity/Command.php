<?php

namespace AppBundle\Domain\Entity;

use AppBundle\Domain\Validator\Constraints\IsClosed;
use AppBundle\Domain\Validator\Constraints\IsHoliday;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * CommandManager
 *
 * @ORM\Table(name="command")
 * @ORM\Entity(repositoryClass="AppBundle\Domain\Repository\CommandRepository")
 */
class Command
{
    const DAY = "Journée";
    const HALF_DAY = "Demi-journée";
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     * @ORM\Column(name="price", type="integer", nullable=true)
     */
    private $price;

    /**
     * @var boolean
     * @ORM\Column(name="payment", type="boolean", nullable=true)
     */
    private $payment = false;
    /**
     * @var string
     *
     * @Assert\NotNull()
     * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email.",
     *     checkMX = true
     *  )
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     */
    private $email;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Domain\Entity\Ticket", mappedBy="command", cascade={"persist"})
     */
    private $tickets;


    /**
     * @var \DateTime;
     * @ORM\Column(name="entry_at", type="datetime", nullable=false)
     * @IsClosed()
     */
    private $entryAt;

    /**
     * @var \DateTime
     * @Assert\NotNull()
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt;

    public function __construct()
    {
        $this->tickets = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Command
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Command
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Command
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @return int
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param int $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * @return mixed
     */
    public function getTickets()
    {
        return $this->tickets;
    }

    /**
     * @param Ticket $ticket
     * @internal param mixed $tickets
     */
    public function addTicket(Ticket $ticket)
    {
        $this->tickets->add($ticket);
    }

    public function removeTicket(Ticket $ticket)
    {
        $this->tickets->removeElement($ticket);
    }

    /**
     * @return mixed
     */
    public function getPayment()
    {
        return $this->payment;
    }

    /**
     * @param mixed $payment
     */
    public function setPayment($payment)
    {
        $this->payment = $payment;
    }

    /**
     * @return mixed
     */
    public function getEntryAt()
    {
        return $this->entryAt;
    }

    /**
     * @param mixed $entryAt
     */
    public function setEntryAt($entryAt)
    {
        $this->entryAt = $entryAt;
    }

}
