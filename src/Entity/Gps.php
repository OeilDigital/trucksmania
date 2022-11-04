<?php

namespace App\Entity;

use App\Repository\GpsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GpsRepository::class)
 */
class Gps
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $latitude;

    /**
     * @ORM\Column(type="integer")
     */
    private $longitude;

    /**
     * @ORM\OneToOne(targetEntity=Address::class, mappedBy="gps", cascade={"persist", "remove"})
     */
    private $address;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLatitude(): ?int
    {
        return $this->latitude;
    }

    public function setLatitude(int $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?int
    {
        return $this->longitude;
    }

    public function setLongitude(int $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getAddress(): ?Address
    {
        return $this->address;
    }

    public function setAddress(?Address $address): self
    {
        // unset the owning side of the relation if necessary
        if ($address === null && $this->address !== null) {
            $this->address->setGps(null);
        }

        // set the owning side of the relation if necessary
        if ($address !== null && $address->getGps() !== $this) {
            $address->setGps($this);
        }

        $this->address = $address;

        return $this;
    }
}
