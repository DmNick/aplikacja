<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\TraitSpace\idTrait;
use App\Repository\MagazynRepository;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: MagazynRepository::class)]
#[UniqueEntity(fields: ['nazwa'], message: 'Istnieje już magazyn o takiej nazwie')]
class Magazyn
{
    use idTrait;

    #[ORM\Column(length: 128, unique: true)]
    private ?string $nazwa = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $domyslny = 0;

    #[ORM\OneToMany(targetEntity: User::class, mappedBy: 'idMagazynu', cascade: ['ondelete'=>'persist', 'onupdate'=>'persist'])]
    private $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
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

    public function getDomyslny(): ?int
    {
        $domyslny = $this->domyslny;
        
        return $domyslny;
    }

    public function setDomyslny(int $domyslny): self
    {
        $this->domyslny = $domyslny;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
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
}
