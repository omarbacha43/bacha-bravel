<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

class SiteSearch
{
    private $favoris;

    public function getFavoris(): ?bool
    {
        return $this->favoris;
    }

    public function setFavoris(bool $favoris): self
    {
        $this->favoris = $favoris;

        return $this;
    }
}
