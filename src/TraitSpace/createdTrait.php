<?php

namespace App\Entity\TraitSpace;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

trait createdTrait {

    #[ORM\Column]
    private ?datetime $created = null;

    public function getCreated():DateTime {
        return $this -> created;
    }

    #[ORM\PrePersist]
    public function onPrePersist() {
        $this -> created = new DateTime("now");
    }
}

