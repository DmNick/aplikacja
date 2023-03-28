<?php

namespace App\Entity;

use App\Repository\WydaniaRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WydaniaRepository::class)]
class Wydania
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $ilosc = null;

    #[ORM\ManyToOne(inversedBy: 'wydanias')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $wydal = null;

    #[ORM\ManyToOne(inversedBy: 'wydanias')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Magazyn $magazyn = null;

    #[ORM\ManyToOne(inversedBy: 'wydanias')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Artykul $artykul = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIlosc(): ?int
    {
        return $this->ilosc;
    }

    public function setIlosc(int $ilosc): self
    {
        $this->ilosc = $ilosc;

        return $this;
    }

    public function getWydal(): ?User
    {
        return $this->wydal;
    }

    public function setWydal(?User $wydal): self
    {
        $this->wydal = $wydal;

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

    public function getArtykul(): ?Artykul
    {
        return $this->artykul;
    }

    public function setArtykul(?Artykul $artykul): self
    {
        $this->artykul = $artykul;

        return $this;
    }
}
