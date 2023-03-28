<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\TraitSpace\idTrait;
use App\Repository\ArtykulRepository;
use App\Entity\TraitSpace\createdTrait;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: ArtykulRepository::class)]
#[ORM\HasLifecycleCallbacks]
//#[UniqueEntity(fields: ['nazwa'], message: 'Istnieje już artykuł o takiej nazwie')]
class Artykul
{
    use idTrait;
    use createdTrait;

    #[ORM\Column(length: 255)]
    private ?string $nazwa = null;

    #[ORM\ManyToOne(targetEntity: Magazyn::class, inversedBy: 'artykuls')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Magazyn $magazyn = null;

    #[ORM\Column(length: 12)]
    private ?string $jednostkaMiary = null;

    #[ORM\Column(nullable: true)]
    private ?int $ilosc = null;

    #[ORM\OneToMany(mappedBy: 'artykul', targetEntity: Przyjecia::class, orphanRemoval: true)]
    private Collection $przyjecias;

    #[ORM\OneToMany(mappedBy: 'artykul', targetEntity: Wydania::class, orphanRemoval: true)]
    private Collection $wydanias;

    public function __construct()
    {
        $this->przyjecias = new ArrayCollection();
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

    public function getMagazyn(): ?Magazyn
    {
        return $this->magazyn;
    }

    public function setMagazyn(?Magazyn $magazyn): self
    {
        $this->magazyn = $magazyn;

        return $this;
    }

    public function getjednostkaMiary(): ?string
    {
        return $this->jednostkaMiary;
    }

    public function setjednostkaMiary(string $jednostkaMiary): self
    {
        $this->jednostkaMiary = $jednostkaMiary;

        return $this;
    }

    public function getIlosc(): ?int
    {
        return $this->ilosc;
    }

    public function setIlosc(?int $ilosc): self
    {
        $this->ilosc = $ilosc;

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
            $przyjecia->setArtykul($this);
        }

        return $this;
    }

    public function removePrzyjecia(Przyjecia $przyjecia): self
    {
        if ($this->przyjecias->removeElement($przyjecia)) {
            // set the owning side to null (unless already changed)
            if ($przyjecia->getArtykul() === $this) {
                $przyjecia->setArtykul(null);
            }
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
            $wydania->setArtykul($this);
        }

        return $this;
    }

    public function removeWydania(Wydania $wydania): self
    {
        if ($this->wydanias->removeElement($wydania)) {
            // set the owning side to null (unless already changed)
            if ($wydania->getArtykul() === $this) {
                $wydania->setArtykul(null);
            }
        }

        return $this;
    }
}
