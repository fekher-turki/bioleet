<?php

namespace App\Entity;

use App\Repository\SocialMediaRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: SocialMediaRepository::class)]
class SocialMedia
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Length(min: 7, max: 37)]
    private ?string $discord = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Url]
    private ?string $facebook = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Url]
    private ?string $instagram = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Url]
    private ?string $twitter = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Url]
    private ?string $vk = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Url]
    private ?string $twitch = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Url]
    private ?string $youtube = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Url]
    private ?string $tiktok = null;

    #[ORM\ManyToOne(inversedBy: 'socialMedia')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDiscord(): ?string
    {
        return $this->discord;
    }

    public function setDiscord(?string $discord): static
    {
        $this->discord = $discord;

        return $this;
    }

    public function getFacebook(): ?string
    {
        return $this->facebook;
    }

    public function setFacebook(?string $facebook): static
    {
        $this->facebook = $facebook;

        return $this;
    }

    public function getInstagram(): ?string
    {
        return $this->instagram;
    }

    public function setInstagram(?string $instagram): static
    {
        $this->instagram = $instagram;

        return $this;
    }

    public function getTwitter(): ?string
    {
        return $this->twitter;
    }

    public function setTwitter(?string $twitter): static
    {
        $this->twitter = $twitter;

        return $this;
    }

    public function getVk(): ?string
    {
        return $this->vk;
    }

    public function setVk(?string $vk): static
    {
        $this->vk = $vk;

        return $this;
    }

    public function getTwitch(): ?string
    {
        return $this->twitch;
    }

    public function setTwitch(?string $twitch): static
    {
        $this->twitch = $twitch;

        return $this;
    }

    public function getYoutube(): ?string
    {
        return $this->youtube;
    }

    public function setYoutube(?string $youtube): static
    {
        $this->youtube = $youtube;

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

    public function getTiktok(): ?string
    {
        return $this->tiktok;
    }

    public function setTiktok(?string $tiktok): static
    {
        $this->tiktok = $tiktok;

        return $this;
    }
}
