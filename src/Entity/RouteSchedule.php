<?php

namespace App\Entity;

use App\Repository\RouteScheduleRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RouteScheduleRepository::class)
 */
class RouteSchedule
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=TransportRoute::class, inversedBy="schedules")
     * @ORM\JoinColumn(nullable=false)
     */
    private $transportRoute;

    /**
     * @ORM\Column(type="datetime")
     */
    private $departureDateTime;

    /**
     * @ORM\Column(type="datetime")
     */
    private $arrivalDateTime;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTransportRoute(): ?TransportRoute
    {
        return $this->transportRoute;
    }

    public function setTransportRoute(?TransportRoute $transportRoute): self
    {
        $this->transportRoute = $transportRoute;

        return $this;
    }

    public function getDepartureDateTime(): ?\DateTimeInterface
    {
        return $this->departureDateTime;
    }

    public function setDepartureDateTime(\DateTimeInterface $departureDateTime): self
    {
        $this->departureDateTime = $departureDateTime;

        return $this;
    }

    public function getArrivalDateTime(): ?\DateTimeInterface
    {
        return $this->arrivalDateTime;
    }

    public function setArrivalDateTime(\DateTimeInterface $arrivalDateTime): self
    {
        $this->arrivalDateTime = $arrivalDateTime;

        return $this;
    }
}
