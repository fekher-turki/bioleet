<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[UniqueEntity('email')]
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\EntityListeners(['App\EntityListener\UserListener'])]
#[Vich\Uploadable]
class User implements UserInterface, PasswordAuthenticatedUserInterface, \Serializable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Assert\Email()]
    #[Assert\NotBlank()]
    #[Assert\Length(min: 2, max: 180)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    private ?string $plainPassword = null;

    private ?string $newPassword = null;

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    #[Assert\NotBlank()]
    private ?string $password = 'password';

    #[ORM\Column(length: 30)]
    #[Assert\NotBlank()]
    #[Assert\Length(min: 2, max: 30)]
    private ?string $firstName = null;

    #[ORM\Column(length: 30)]
    #[Assert\NotBlank()]
    #[Assert\Length(min: 2, max: 30)]
    private ?string $lastName = null;

    #[ORM\Column(length: 50, unique: true)]
    #[Assert\NotBlank()]
    #[Assert\Length(min: 2, max: 50)]
    private ?string $username = null;

    #[ORM\Column(length: 50, nullable: true)]
    #[Assert\Length(min: 2, max: 50)]
    private ?string $nickname = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank()]
    #[Assert\Length(min: 1, max: 50)]
    private ?string $gender = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Assert\NotBlank()]
    #[Assert\LessThanOrEqual("-16 years")]
    private ?\DateTimeInterface $birthday = null;

    #[Vich\UploadableField(mapping: 'user_avatar', fileNameProperty: 'avatar')]
    private ?File $avatarFile = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $avatar = "default-avatar.png";

    #[ORM\Column]
    private ?bool $isVerified = false;

    #[ORM\Column]
    private ?bool $isFirstLogin = true;

    #[ORM\Column(type: Types::DATETIMETZ_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $banStart = null;

    #[ORM\Column(type: Types::DATETIMETZ_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $banEnd = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $banReason = null;

    #[ORM\Column(type: Types::DATETIMETZ_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $premiumStart = null;

    #[ORM\Column(type: Types::DATETIMETZ_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $premiumEnd = null;

    #[ORM\Column]
    #[Assert\NotNull()]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    #[Assert\NotNull()]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: SocialMedia::class, orphanRemoval: true)]
    private Collection $socialMedia;

    #[ORM\Column(length: 255)]
    private ?string $country = null;

    #[ORM\Column(type: Types::JSON, nullable: true)]
    private array $languages = [];

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Profile::class, orphanRemoval: true)]
    private Collection $profiles;

    #[ORM\OneToMany(mappedBy: 'owner', targetEntity: Team::class, orphanRemoval: true)]
    private Collection $teams;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Setup::class, orphanRemoval: true)]
    private Collection $setup;

    public function __construct()
    {
        $this->nickname = $this->username;
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
        $this->socialMedia = new ArrayCollection();
        $this->profiles = new ArrayCollection();
        $this->teams = new ArrayCollection();
        $this->setup = new ArrayCollection();
    }

    #[ORM\PrePersist]
    public function setUpdatedAtValue()
    {
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    public function getNewPassword()
    {
        return $this->newPassword;
    }

    public function setNewPassword($newPassword)
    {
        $this->newPassword = $newPassword;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function getNickname(): ?string
    {
        return $this->nickname;
    }

    public function setNickname(string $nickname): static
    {
        $this->nickname = $nickname;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(string $gender): static
    {
        $this->gender = $gender;

        return $this;
    }

    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->birthday;
    }

    public function setBirthday(\DateTimeInterface $birthday): static
    {
        $this->birthday = $birthday;

        return $this;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(?string $avatar): void
    {
        $this->avatar = $avatar;
    }

    public function getAvatarFile(): ?File
    {
        return $this->avatarFile;
    }

    public function setAvatarFile(?File $avatarFile = null): void
    {
        $this->avatarFile = $avatarFile;

        if ($this->avatarFile instanceof UploadedFile) {
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function serialize()
    {

        return serialize(array(
            $this->id,
            $this->username,
            $this->email,
            $this->password,
        ));
    }

    public function unserialize($serialized)
    {

        list(
            $this->id,
            $this->username,
            $this->email,
            $this->password,
        ) = unserialize($serialized);
    }

    public function isIsVerified(): ?bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): static
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    public function isIsFirstLogin(): ?bool
    {
        return $this->isFirstLogin;
    }

    public function setIsFirstLogin(bool $isFirstLogin): static
    {
        $this->isFirstLogin = $isFirstLogin;

        return $this;
    }

    public function getBanStart(): ?\DateTimeInterface
    {
        return $this->banStart;
    }

    public function setBanStart(?\DateTimeInterface $banStart): static
    {
        $this->banStart = $banStart;

        return $this;
    }

    public function getBanEnd(): ?\DateTimeInterface
    {
        return $this->banEnd;
    }

    public function setBanEnd(?\DateTimeInterface $banEnd): static
    {
        $this->banEnd = $banEnd;

        return $this;
    }

    public function getBanReason(): ?string
    {
        return $this->banReason;
    }

    public function setBanReason(?string $banReason): static
    {
        $this->banReason = $banReason;

        return $this;
    }

    public function getPremiumStart(): ?\DateTimeInterface
    {
        return $this->premiumStart;
    }

    public function setPremiumStart(?\DateTimeInterface $premiumStart): static
    {
        $this->premiumStart = $premiumStart;

        return $this;
    }

    public function getPremiumEnd(): ?\DateTimeInterface
    {
        return $this->premiumEnd;
    }

    public function setPremiumEnd(?\DateTimeInterface $premiumEnd): static
    {
        $this->premiumEnd = $premiumEnd;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getSocialMedia(): ?SocialMedia
    {
        return $this->socialMedia->first() ?: null;
    }

    public function addSocialMedia(SocialMedia $socialMedia): static
    {
        if (!$this->socialMedia->contains($socialMedia)) {
            $this->socialMedia->add($socialMedia);
            $socialMedia->setUser($this);
        }

        return $this;
    }

    public function removeSocialMedia(SocialMedia $socialMedia): static
    {
        if ($this->socialMedia->removeElement($socialMedia)) {
            // set the owning side to null (unless already changed)
            if ($socialMedia->getUser() === $this) {
                $socialMedia->setUser(null);
            }
        }

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): static
    {
        $this->country = $country;

        return $this;
    }

    public function getLanguages(): array
    {
        return $this->languages;
    }

    public function setLanguages(?array $languages): static
    {
        $this->languages = $languages;

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
            $profile->setUser($this);
        }

        return $this;
    }

    public function removeProfile(Profile $profile): static
    {
        if ($this->profiles->removeElement($profile)) {
            // set the owning side to null (unless already changed)
            if ($profile->getUser() === $this) {
                $profile->setUser(null);
            }
        }

        return $this;
    }

    public function isPremium(): bool
    {
        $now = new \DateTime();
        $premiumEnd = $this->getPremiumEnd();
        
        return $premiumEnd !== null && $premiumEnd > $now;
    }

    public function isBanned(): bool
    {
        $now = new \DateTime();
        $banEnd = $this->getBanEnd();
        
        return $banEnd !== null && $banEnd > $now;
    }

    /**
     * @return Collection<int, Team>
     */
    public function getTeams(): Collection
    {
        return $this->teams;
    }

    public function addTeam(Team $team): static
    {
        if (!$this->teams->contains($team)) {
            $this->teams->add($team);
            $team->setOwner($this);
        }

        return $this;
    }

    public function removeTeam(Team $team): static
    {
        if ($this->teams->removeElement($team)) {
            // set the owning side to null (unless already changed)
            if ($team->getOwner() === $this) {
                $team->setOwner(null);
            }
        }

        return $this;
    }

    public function getSetup(): ?Setup
    {
        return $this->setup->first() ?: null;
    }

    public function addSetup(Setup $setup): static
    {
        if (!$this->setup->contains($setup)) {
            $this->setup->add($setup);
            $setup->setUser($this);
        }

        return $this;
    }

    public function removeSetup(Setup $setup): static
    {
        if ($this->setup->removeElement($setup)) {
            // set the owning side to null (unless already changed)
            if ($setup->getUser() === $this) {
                $setup->setUser(null);
            }
        }

        return $this;
    }
}
