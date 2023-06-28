<?php

namespace App\Entity;

use App\Repository\ExperienceRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExperienceRepository::class)]
class Experience
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIMETZ_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(length: 15, nullable: true)]
    private ?string $place = null;

    #[ORM\Column(length: 255)]
    private ?string $tournamentName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $tournamentLink = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $tournamentLogo = null;

    #[ORM\Column(length: 100)]
    private ?string $teamName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $teamLogo = null;

    #[ORM\ManyToOne(inversedBy: 'experiences')]
    private ?Profile $profile = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getPlace(): ?string
    {
        return $this->place;
    }

    public function setPlace(?string $place): static
    {
        $this->place = $place;

        return $this;
    }

    public function getTournamentName(): ?string
    {
        return $this->tournamentName;
    }

    public function setTournamentName(string $tournamentName): static
    {
        $this->tournamentName = $tournamentName;

        return $this;
    }

    public function getTournamentLink(): ?string
    {
        return $this->tournamentLink;
    }

    public function setTournamentLink(?string $tournamentLink): static
    {
        $this->tournamentLink = $tournamentLink;

        return $this;
    }

    public function getTournamentLogo(): ?string
    {
        return $this->tournamentLogo;
    }

    public function setTournamentLogo(?string $tournamentLogo): static
    {
        $this->tournamentLogo = $tournamentLogo;

        return $this;
    }

    public function getTeamName(): ?string
    {
        return $this->teamName;
    }

    public function setTeamName(string $teamName): static
    {
        $this->teamName = $teamName;

        return $this;
    }

    public function getTeamLogo(): ?string
    {
        return $this->teamLogo;
    }

    public function setTeamLogo(?string $teamLogo): static
    {
        $this->teamLogo = $teamLogo;

        return $this;
    }

    public function getProfile(): ?Profile
    {
        return $this->profile;
    }

    public function setProfile(?Profile $profile): static
    {
        $this->profile = $profile;

        return $this;
    }
}
