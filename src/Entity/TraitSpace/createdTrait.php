<?php

namespace App\Entity\TraitSpace;

use DateTime;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

trait createdTrait {

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $created = null;

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    #[ORM\PrePersist]
    public function onPrePersist(): void {
        $this -> created = new DateTime('now');
    }
}



    // public function setCreatedAccount(?\DateTimeInterface $createdAccount): self
    // {
    //     $this->createdAccount = $createdAccount;

    //     return $this;
    // }