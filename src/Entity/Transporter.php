<?php

namespace App\Entity;

use App\Repository\TransporterRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TransporterRepository::class)
 */
class Transporter
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
     * @ORM\Column(type="string", length=255)
     */
    private $code;

    /**
     * @ORM\OneToMany(targetEntity=TransportRoute::class, mappedBy="trasporter", orphanRemoval=true)
     */
    private $routes;

    public function __construct()
    {
        $this->routes = new ArrayCollection();
    }

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

    /**
     * @return Collection|TransportRoute[]
     */
    public function getRoutes(): Collection
    {
        return $this->routes;
    }

    public function addRoute(TransportRoute $route): self
    {
        if (!$this->routes->contains($route)) {
            $this->routes[] = $route;
            $route->setTransporter($this);
        }

        return $this;
    }

    public function removeRoute(TransportRoute $route): self
    {
        if ($this->routes->removeElement($route)) {
            // set the owning side to null (unless already changed)
            if ($route->getTransporter() === $this) {
                $route->setTransporter(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getName();
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }
}
