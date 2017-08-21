<?php

namespace AppBundle\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Domain\Validator\Constraints as CustomAssert;

/**
 * Ticket
 *
 * @ORM\Table(name="ticket")
 * @ORM\Entity(repositoryClass="AppBundle\Domain\Repository\TicketRepository")
 * @CustomAssert\IsHalfDay
 */
class Ticket
{
    const TICKET_LIMIT = 1000;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @Assert\NotNull()
     * @ORM\Column(name="first_name", type="string", length=255, nullable=false)
     */
    private $firstName;

    /**
     * @var string
     * @Assert\NotNull()
     * @ORM\Column(name="last_name", type="string", length=255, nullable=false)
     */
    private $lastName;

    /**
     * @var \DateTime
     * @Assert\NotNull()
     * @ORM\Column(name="birthday", type="date", nullable=false)
     */
    private $birthday;

    /**
     * @var string
     *
     * @Assert\NotBlank(message="country should not be blank")
     * @ORM\Column(name="country", type="string", length=255, nullable=false)
     */
    private $country;

    /**
     * @var bool
     *
     * @ORM\Column(name="reduction", type="boolean", nullable=false)
     */
    private $reduction;

    /**
     * @var int
     * @Assert\NotNull()
     * @ORM\Column(name="price", type="integer", nullable=false)
     */
    private $price;

    /**
     * @var Command
     * @ORM\ManyToOne(targetEntity="AppBundle\Domain\Entity\Command", inversedBy="tickets", cascade={"persist"})
     * @Assert\NotNull()
     * @ORM\JoinColumn(referencedColumnName="id", nullable=false)
     */
    private $command;

    /**
     * @var \DateTime
     * @ORM\Column(name="entry_at", type="datetime")
     * @CustomAssert\IsClosed()
     */
    private $entryAt;

    /**
     * @var \DateTime
     * @Assert\NotNull()
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

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
     * Set firstName
     *
     * @param string $firstName
     *
     * @return Ticket
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return Ticket
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set birthday
     *
     * @return Ticket
     */
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;

        return $this;
    }

    /**
     * Get birthday
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * Set country
     *
     * @param string $country
     *
     * @return Ticket
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set reduction
     *
     * @param boolean $reduction
     *
     * @return Ticket
     */
    public function setReduction($reduction)
    {
        $this->reduction = $reduction;

        return $this;
    }

    /**
     * Get reduction
     *
     * @return bool
     */
    public function getReduction()
    {
        return $this->reduction;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Ticket
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set command
     *
     *
     * @param Command $command
     * @return Ticket
     */
    public function setCommand(Command $command)
    {
        $this->command = $command;

        return $this;
    }

    /**
     * Get command
     *
     * @return \AppBundle\Domain\Entity\Command
     */
    public function getCommand()
    {
        return $this->command;
    }

    /**
     * @return int
     */
    public function getPrice(): int
    {
        return $this->price;
    }

    /**
     * @param int $price
     */
    public function setPrice(int $price)
    {
        $this->price = $price;
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
