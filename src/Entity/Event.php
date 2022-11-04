<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EventRepository::class)
 */
class Event
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $event_name;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $trucks_amount;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $starter_date;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $due_date;

    /**
     * @ORM\ManyToOne(targetEntity=Professional::class, inversedBy="events")
     * @ORM\JoinColumn(nullable=false)
     */
    private $professional;

    /**
     * @ORM\ManyToOne(targetEntity=Address::class, inversedBy="events")
     * @ORM\JoinColumn(nullable=false)
     */
    private $address;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEventName(): ?string
    {
        return $this->event_name;
    }

    public function setEventName(string $event_name): self
    {
        $this->event_name = $event_name;

        return $this;
    }

    public function getTrucksAmount(): ?int
    {
        return $this->trucks_amount;
    }

    public function setTrucksAmount(?int $trucks_amount): self
    {
        $this->trucks_amount = $trucks_amount;

        return $this;
    }

    public function getStarterDate(): ?\DateTimeInterface
    {
        return $this->starter_date;
    }

    public function setStarterDate(?\DateTimeInterface $starter_date): self
    {
        $this->starter_date = $starter_date;

        return $this;
    }

    public function getDueDate(): ?\DateTimeInterface
    {
        return $this->due_date;
    }

    public function setDueDate(?\DateTimeInterface $due_date): self
    {
        $this->due_date = $due_date;

        return $this;
    }

    public function getProfessional(): ?Professional
    {
        return $this->professional;
    }

    public function setProfessional(?Professional $professional): self
    {
        $this->professional = $professional;

        return $this;
    }

    public function getAddress(): ?Address
    {
        return $this->address;
    }

    public function setAddress(?Address $address): self
    {
        $this->address = $address;

        return $this;
    }
}
