<?php

namespace App\Entity;

use App\Repository\TransportRouteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TransportRouteRepository::class)
 */
class TransportRoute
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity=Transporter::class, inversedBy="routes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $transporter;

    /**
     * @ORM\ManyToOne(targetEntity=Airport::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $departureAirport;

    /**
     * @ORM\ManyToOne(targetEntity=Airport::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $arrivalAirport;

    /**
     * @ORM\Column(type="integer")
     */
    private $duration;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getTransporter(): ?Transporter
    {
        return $this->transporter;
    }

    public function setTransporter(?Transporter $transporter): self
    {
        $this->transporter = $transporter;

        return $this;
    }

    public function getDepartureAirport(): ?Airport
    {
        return $this->departureAirport;
    }

    public function setDepartureAirport(?Airport $departureAirport): self
    {
        $this->departureAirport = $departureAirport;

        return $this;
    }

    public function getArrivalAirport(): ?Airport
    {
        return $this->arrivalAirport;
    }

    public function setArrivalAirport(?Airport $arrivalAirport): self
    {
        $this->arrivalAirport = $arrivalAirport;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): self
    {
        $this->duration = $duration;

        return $this;
    }
}
