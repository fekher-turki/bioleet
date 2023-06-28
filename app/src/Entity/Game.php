<?php

namespace App\Entity;

use App\Repository\GameRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GameRepository::class)]
class Game
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 10)]
    private ?string $code = null;

    #[ORM\ManyToMany(targetEntity: GameRole::class, inversedBy: 'games')]
    private Collection $gameRole;

    #[ORM\OneToMany(mappedBy: 'game', targetEntity: Profile::class)]
    private Collection $profiles;

    public function __construct()
    {
        $this->gameRole = new ArrayCollection();
        $this->profiles = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->name;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): static
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return Collection<int, GameRole>
     */
    public function getGameRole(): Collection
    {
        return $this->gameRole;
    }

    public function addGameRole(GameRole $gameRole): static
    {
        if (!$this->gameRole->contains($gameRole)) {
            $this->gameRole->add($gameRole);
        }

        return $this;
    }

    public function removeGameRole(GameRole $gameRole): static
    {
        $this->gameRole->removeElement($gameRole);

        return $this;
    }

    /**
     * @return Collection<int, Profile>
     */
    public function getProfiles(): Collection
    {
        return $this->profiles;
    }

    public function addProfile(Profile $profile): static
    {
        if (!$this->profiles->contains($profile)) {
            $this->profiles->add($profile);
            $profile->setGame($this);
        }

        return $this;
    }

    public function removeProfile(Profile $profile): static
    {
        if ($this->profiles->removeElement($profile)) {
            // set the owning side to null (unless already changed)
            if ($profile->getGame() === $this) {
                $profile->setGame(null);
            }
        }

        return $this;
    }
}
