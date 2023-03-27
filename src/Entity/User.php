<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\TraitSpace\idTrait;
use App\Repository\UserRepository;
use App\Entity\TraitSpace\createdTrait;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Form\FormTypeInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[UniqueEntity(fields: ['email'], message: 'Istnieje już konto z tym adresem email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    use idTrait;
    use createdTrait;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\ManyToOne(targetEntity: Magazyn::class, inversedBy: 'users', cascade: ['ondelete'=>'persist', 'onupdate'=>'persist'])]
    private $idMagazynu;

    #[ORM\OneToMany(mappedBy: 'wprowadzil', targetEntity: Przyjecia::class)]
    private Collection $przyjecias;

    #[ORM\ManyToMany(targetEntity: Magazyn::class, inversedBy: 'magUsers')]
    private Collection $listaMagazynow;

    public function __construct()
    {
        $this->przyjecias = new ArrayCollection();
        $this->listaMagazynow = new ArrayCollection();
    }

    
    public function __toString()
    {
        return $this;
    }

    
    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
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

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getIdMagazynu(): ?Magazyn
    {
        return $this->idMagazynu;
    }

    public function setIdMagazynu(?Magazyn $idMagazynu): self
    {
        $this->idMagazynu = $idMagazynu;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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
            $przyjecia->setWprowadzil($this);
        }

        return $this;
    }

    public function removePrzyjecia(Przyjecia $przyjecia): self
    {
        if ($this->przyjecias->removeElement($przyjecia)) {
            // set the owning side to null (unless already changed)
            if ($przyjecia->getWprowadzil() === $this) {
                $przyjecia->setWprowadzil(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Magazyn>
     */
    public function getListaMagazynow(): Collection
    {
        return $this->listaMagazynow;
    }

    public function addListaMagazynow(Magazyn $listaMagazynow): self
    {
        if (!$this->listaMagazynow->contains($listaMagazynow)) {
            $this->listaMagazynow->add($listaMagazynow);
        }

        return $this;
    }

    public function removeListaMagazynow(Magazyn $listaMagazynow): self
    {
        $this->listaMagazynow->removeElement($listaMagazynow);

        return $this;
    }

    

}
