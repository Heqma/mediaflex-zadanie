<?php

namespace App\Entity;

use App\Repository\AppListRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AppListRepository::class)]
class AppList
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(length: 255)]
    private string $name;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'userApp')]
    private Collection $AppUser;

    public function __construct()
    {
        $this->AppUser = new ArrayCollection();
    }

    public function __toString() {
        return $this->name;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, user>
     */
    public function getAppUser(): Collection
    {
        return $this->AppUser;
    }

    public function addAppUser(user $appUser): self
    {
        if (!$this->AppUser->contains($appUser)) {
            $this->AppUser->add($appUser);
        }

        return $this;
    }

    public function removeAppUser(user $appUser): self
    {
        $this->AppUser->removeElement($appUser);

        return $this;
    }
}
