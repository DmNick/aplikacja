<?php

namespace App\Entity;

use App\Entity\TraitSpace\createdTrait;
use App\Entity\TraitSpace\idTrait;
use App\Repository\ArtykulRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArtykulRepository::class)]
class Artykul
{
    use idTrait;
    use createdTrait;

    #[ORM\Column(length: 255)]
    private ?string $nazwa = null;

    #[ORM\Column(nullable: true)]
    private ?int $ilosc = null;

    #[ORM\Column(nullable: true)]
    private ?int $vat = null;

    #[ORM\Column(nullable: true)]
    private ?int $cena = null;

    #[ORM\Column(nullable: true)]
    private array $pliki = [];

    #[ORM\ManyToOne(targetEntity: Magazyn::class, inversedBy: 'artykuls')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Magazyn $magazyn = null;

    #[ORM\ManyToOne(inversedBy: 'artykuls')]
    private ?JednostkiMiary $jednostkaMiary = null;

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

    public function getIlosc(): ?int
    {
        return $this->ilosc;
    }

    public function setIlosc(?int $ilosc): self
    {
        $this->ilosc = $ilosc;

        return $this;
    }

    public function getVat(): ?int
    {
        return $this->vat;
    }

    public function setVat(?int $vat): self
    {
        $this->vat = $vat;

        return $this;
    }

    public function getCena(): ?int
    {
        return $this->cena;
    }

    public function setCena(?int $cena): self
    {
        $this->cena = $cena;

        return $this;
    }

    public function getPliki(): array
    {
        return $this->pliki;
    }

    public function setPliki(?array $pliki): self
    {
        $this->pliki = $pliki;

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

    public function getJednostkaMiary(): ?JednostkiMiary
    {
        return $this->jednostkaMiary;
    }

    public function setJednostkaMiary(?JednostkiMiary $jednostkaMiary): self
    {
        $this->jednostkaMiary = $jednostkaMiary;

        return $this;
    }
}
