<?php

namespace App\Entity;

use App\Repository\AddressRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AddressRepository::class)
 */
class Address
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
    private $street_number;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $street_name;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $post_code;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $city;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $additional_address;

    /**
     * @ORM\Column(type="array", nullable=false)
     */
    private $days_of_presence;

    /**
     * @ORM\OneToOne(targetEntity=Gps::class, inversedBy="address", cascade={"persist", "remove"})
     */
    private $gps;

    /**
     * @ORM\ManyToMany(targetEntity=Truck::class, inversedBy="addresses", cascade={"persist"})
     */
    private $truck;

    /**
     * @ORM\OneToMany(targetEntity=Event::class, mappedBy="address")
     */
    private $events;

    /**
     * @ORM\ManyToMany(targetEntity=Customer::class, mappedBy="address")
     */
    private $customers;

    public function __construct()
    {
        $this->truck = new ArrayCollection();
        $this->events = new ArrayCollection();
        $this->customers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStreetNumber(): ?string
    {
        return $this->street_number;
    }

    public function setStreetNumber(string $street_number): self
    {
        $this->street_number = $street_number;

        return $this;
    }

    public function getStreetName(): ?string
    {
        return $this->street_name;
    }

    public function setStreetName(string $street_name): self
    {
        $this->street_name = $street_name;

        return $this;
    }

    public function getPostCode(): ?string
    {
        return $this->post_code;
    }

    public function setPostCode(string $post_code): self
    {
        $this->post_code = $post_code;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getAdditionalAddress(): ?string
    {
        return $this->additional_address;
    }

    public function setAdditionalAddress(?string $additional_address): self
    {
        $this->additional_address = $additional_address;

        return $this;
    }

    public function getDaysOfPresence(): ?array
    {
        return $this->days_of_presence;
    }

    public function setDaysOfPresence(array $days_of_presence): self
    {
        $this->days_of_presence = $days_of_presence;

        return $this;
    }

    public function getGps(): ?Gps
    {
        return $this->gps;
    }

    public function setGps(?Gps $gps): self
    {
        $this->gps = $gps;

        return $this;
    }

    /**
     * @return Collection|Truck[]
     */
    public function getTruck(): Collection
    {
        return $this->truck;
    }

    public function addTruck(Truck $truck): self
    {
        if (!$this->truck->contains($truck)) {
            $this->truck[] = $truck;
        }

        return $this;
    }

    public function removeTruck(Truck $truck): self
    {
        $this->truck->removeElement($truck);

        return $this;
    }

    /**
     * @return Collection|Event[]
     */
    public function getEvents(): Collection
    {
        return $this->events;
    }

    public function addEvent(Event $event): self
    {
        if (!$this->events->contains($event)) {
            $this->events[] = $event;
            $event->setAddress($this);
        }

        return $this;
    }

    public function removeEvent(Event $event): self
    {
        if ($this->events->removeElement($event)) {
            // set the owning side to null (unless already changed)
            if ($event->getAddress() === $this) {
                $event->setAddress(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Customer[]
     */
    public function getCustomers(): Collection
    {
        return $this->customers;
    }

    public function addCustomer(Customer $customer): self
    {
        if (!$this->customers->contains($customer)) {
            $this->customers[] = $customer;
            $customer->addAddress($this);
        }

        return $this;
    }

    public function removeCustomer(Customer $customer): self
    {
        if ($this->customers->removeElement($customer)) {
            $customer->removeAddress($this);
        }

        return $this;
    }
}
