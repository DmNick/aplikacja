<?php

namespace App\Entity;

use App\Repository\JednostkiMiaryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: JednostkiMiaryRepository::class)]
class JednostkiMiary
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 12)]
    private ?string $nazwa = null;

    #[ORM\OneToMany(mappedBy: 'jednostkaMiary', targetEntity: Artykul::class)]
    private Collection $artykuls;

    public function __construct()
    {
        $this->artykuls = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
     * @return Collection<int, Artykul>
     */
    public function getArtykuls(): Collection
    {
        return $this->artykuls;
    }

    public function addArtykul(Artykul $artykul): self
    {
        if (!$this->artykuls->contains($artykul)) {
            $this->artykuls->add($artykul);
            $artykul->setJednostkaMiary($this);
        }

        return $this;
    }

    public function removeArtykul(Artykul $artykul): self
    {
        if ($this->artykuls->removeElement($artykul)) {
            // set the owning side to null (unless already changed)
            if ($artykul->getJednostkaMiary() === $this) {
                $artykul->setJednostkaMiary(null);
            }
        }

        return $this;
    }
}
