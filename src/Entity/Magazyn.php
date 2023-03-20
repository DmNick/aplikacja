<?php

namespace App\Entity;

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

    #[ORM\Column(type: Types::SMALLINT, nullable:true)]
    private ?int $domyslny = null;

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
        $domyslny = $this->domyslny ?? '0';
        
        return $domyslny;
    }

    public function setDomyslny(int $domyslny): self
    {
        $this->domyslny = $domyslny;

        return $this;
    }
}
