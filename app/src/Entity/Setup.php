<?php

namespace App\Entity;

use App\Repository\SetupRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SetupRepository::class)]
class Setup
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $cpu = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $gpu = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $ram = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $disk = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $monitor = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $mouse = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $keyboard = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $mousepad = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $headphone = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $microphone = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $console = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $controller = null;

    #[ORM\ManyToOne(inversedBy: 'setup')]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCpu(): ?string
    {
        return $this->cpu;
    }

    public function setCpu(?string $cpu): static
    {
        $this->cpu = $cpu;

        return $this;
    }

    public function getGpu(): ?string
    {
        return $this->gpu;
    }

    public function setGpu(?string $gpu): static
    {
        $this->gpu = $gpu;

        return $this;
    }

    public function getRam(): ?string
    {
        return $this->ram;
    }

    public function setRam(?string $ram): static
    {
        $this->ram = $ram;

        return $this;
    }

    public function getDisk(): ?string
    {
        return $this->disk;
    }

    public function setDisk(?string $disk): static
    {
        $this->disk = $disk;

        return $this;
    }

    public function getMonitor(): ?string
    {
        return $this->monitor;
    }

    public function setMonitor(?string $monitor): static
    {
        $this->monitor = $monitor;

        return $this;
    }

    public function getMouse(): ?string
    {
        return $this->mouse;
    }

    public function setMouse(?string $mouse): static
    {
        $this->mouse = $mouse;

        return $this;
    }

    public function getKeyboard(): ?string
    {
        return $this->keyboard;
    }

    public function setKeyboard(?string $keyboard): static
    {
        $this->keyboard = $keyboard;

        return $this;
    }

    public function getMousepad(): ?string
    {
        return $this->mousepad;
    }

    public function setMousepad(?string $mousepad): static
    {
        $this->mousepad = $mousepad;

        return $this;
    }

    public function getHeadphone(): ?string
    {
        return $this->headphone;
    }

    public function setHeadphone(?string $headphone): static
    {
        $this->headphone = $headphone;

        return $this;
    }

    public function getMicrophone(): ?string
    {
        return $this->microphone;
    }

    public function setMicrophone(?string $microphone): static
    {
        $this->microphone = $microphone;

        return $this;
    }

    public function getConsole(): ?string
    {
        return $this->console;
    }

    public function setConsole(?string $console): static
    {
        $this->console = $console;

        return $this;
    }

    public function getController(): ?string
    {
        return $this->controller;
    }

    public function setController(?string $controller): static
    {
        $this->controller = $controller;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }
}
