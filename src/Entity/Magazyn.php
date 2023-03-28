<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\TraitSpace\idTrait;
use App\Repository\MagazynRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: MagazynRepository::class)]
#[UniqueEntity(fields: ['nazwa'], message: 'Istnieje już magazyn o takiej nazwie')]
class Magazyn
{
    use idTrait;

    #[ORM\Column(length: 128, unique: true)]
    private ?string $nazwa = null;

    #[ORM\OneToMany(targetEntity: User::class, mappedBy: 'idMagazynu', cascade: ['ondelete'=>'persist', 'onupdate'=>'persist'])]
    private \Doctrine\Common\Collections\Collection $users;

    #[ORM\OneToMany(mappedBy: 'magazyn', targetEntity: Artykul::class)]
    private \Doctrine\Common\Collections\Collection $artykuls;

    #[ORM\OneToMany(mappedBy: 'magazyn', targetEntity: Przyjecia::class, orphanRemoval: true)]
    private Collection $przyjecias;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'listaMagazynow')]
    private Collection $magUsers;

    #[ORM\OneToMany(mappedBy: 'magazyn', targetEntity: Wydania::class, orphanRemoval: true)]
    private Collection $wydanias;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->artykuls = new ArrayCollection();
        $this->przyjecias = new ArrayCollection();
        $this->magUsers = new ArrayCollection();
        $this->wydanias = new ArrayCollection();
    }

    public function getNazwa(): ?string
    {
        return $this->nazwa;
    }

    public function setNazwa(string $nazwa): self
    {
        $this->nazwa = $nazwa;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): ArrayCollection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->setIdMagazynu($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getIdMagazynu() === $this) {
                $user->setIdMagazynu(null);
            }
        }

        return $this;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection<int, Artykul>
     */
    public function getArtykuls(): \Doctrine\Common\Collections\Collection
    {
        return $this->artykuls;
    }

    public function addArtykul(Artykul $artykul): self
    {
        if (!$this->artykuls->contains($artykul)) {
            $this->artykuls->add($artykul);
            $artykul->setMagazyn($this);
        }

        return $this;
    }

    public function removeArtykul(Artykul $artykul): self
    {
        if ($this->artykuls->removeElement($artykul)) {
            // set the owning side to null (unless already changed)
            if ($artykul->getMagazyn() === $this) {
                $artykul->setMagazyn(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Przyjecia>
     */
    public function getPrzyjecias(): Collection
    {
        return $this->przyjecias;
    }

    public function addPrzyjecia(Przyjecia $przyjecia): self
    {
        if (!$this->przyjecias->contains($przyjecia)) {
            $this->przyjecias->add($przyjecia);
            $przyjecia->setMagazyn($this);
        }

        return $this;
    }

    public function removePrzyjecia(Przyjecia $przyjecia): self
    {
        if ($this->przyjecias->removeElement($przyjecia)) {
            // set the owning side to null (unless already changed)
            if ($przyjecia->getMagazyn() === $this) {
                $przyjecia->setMagazyn(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getMagUsers(): Collection
    {
        return $this->magUsers;
    }

    public function addMagUser(User $magUser): self
    {
        if (!$this->magUsers->contains($magUser)) {
            $this->magUsers->add($magUser);
            $magUser->addListaMagazynow($this);
        }

        return $this;
    }

    public function removeMagUser(User $magUser): self
    {
        if ($this->magUsers->removeElement($magUser)) {
            $magUser->removeListaMagazynow($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Wydania>
     */
    public function getWydanias(): Collection
    {
        return $this->wydanias;
    }

    public function addWydania(Wydania $wydania): self
    {
        if (!$this->wydanias->contains($wydania)) {
            $this->wydanias->add($wydania);
            $wydania->setMagazyn($this);
        }

        return $this;
    }

    public function removeWydania(Wydania $wydania): self
    {
        if ($this->wydanias->removeElement($wydania)) {
            // set the owning side to null (unless already changed)
            if ($wydania->getMagazyn() === $this) {
                $wydania->setMagazyn(null);
            }
        }

        return $this;
    }
}
