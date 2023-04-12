<?php

namespace App\Entity\TraitSpace;

use Doctrine\ORM\Mapping as ORM;

trait idTrait {

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    public function getId(): ?int
    {
        return $this->id;
    }
}