<?php

namespace App\Entity;

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
}
