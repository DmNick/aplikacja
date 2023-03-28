<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\TraitSpace\idTrait;
use App\Entity\TraitSpace\createdTrait;
use App\Repository\PrzyjeciaRepository;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PrzyjeciaRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Przyjecia
{
    use idTrait;
    use createdTrait;

    #[ORM\Column]
    private ?int $ilosc = null;

    #[ORM\Column]
    private ?int $vat = null;

    #[ORM\Column]
    private ?float $cenaNetto = null;

    #[ORM\Column(nullable: true)]
    private ?array $plik = null;

    #[ORM\ManyToOne(inversedBy: 'przyjecias')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $wprowadzil = null;

    #[ORM\ManyToOne(inversedBy: 'przyjecias')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Magazyn $magazyn = null;

    #[ORM\ManyToOne(inversedBy: 'przyjecias')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Artykul $artykul = null;

    private $file; 

    public function getIlosc(): ?int
    {
        return $this->ilosc;
    }

    public function setIlosc(int $ilosc): self
    {
        $this->ilosc = $ilosc;

        return $this;
    }

    public function getVat(): ?int
    {
        return $this->vat;
    }

    public function setVat(int $vat): self
    {
        $this->vat = $vat;

        return $this;
    }

    public function getCenaNetto(): ?float
    {
        return $this->cenaNetto;
    }

    public function setCenaNetto(float $cenaNetto): self
    {
        $this->cenaNetto = $cenaNetto;

        return $this;
    }

    public function getPlik(): ?array
    {
        $plik = $this->plik;
        return $plik;
    }

    public function setPlik(array $plik): self
    {
        $this->plik = $plik;

        return $this;
    }

    public function addPlik($plik): self
    {
        $this->plik[] = $plik;

        return $this;
    }

    public function getWprowadzil(): ?User
    {
        return $this->wprowadzil;
    }

    public function setWprowadzil(?User $wprowadzil): self
    {
        $this->wprowadzil = $wprowadzil;

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
