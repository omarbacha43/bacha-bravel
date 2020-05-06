<?php

namespace App\Entity;

use Cocur\Slugify\Slugify;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * @ORM\Entity(repositoryClass="App\Repository\DestinationRepository")
 * @ORM\HasLifecycleCallbacks
 *
 */
class Destination
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $photo;


    /**
     * @ORM\OneToMany(targetEntity="App\Entity\SiteTouristique", mappedBy="destination", cascade={"persist", "remove"})
     */
    private $siteTouristiques;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $destination;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $auteur;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $favoris;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $prix;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $ancienPrix;

    /**
     * Permet d'initialiser le slug
     *
     * @ORM\PrePersist
     * @ORM\PreUpdate
     *
     */
    public function initialisationSlug(){
        if (empty($this->slug)){
            $slugify = new Slugify();

            $this->slug = $slugify->slugify($this->destination);
        }
    }

    public function __construct()
    {
        $this->sites = new ArrayCollection();
        $this->siteTouristiques = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * @return Collection|SiteTouristique[]
     */
    public function getSiteTouristiques(): Collection
    {
        return $this->siteTouristiques;
    }

    public function addSiteTouristique(SiteTouristique $siteTouristique): self
    {
        if (!$this->siteTouristiques->contains($siteTouristique)) {
            $this->siteTouristiques[] = $siteTouristique;
            $siteTouristique->setDestination($this);
        }

        return $this;
    }

    public function removeSiteTouristique(SiteTouristique $siteTouristique): self
    {
        if ($this->siteTouristiques->contains($siteTouristique)) {
            $this->siteTouristiques->removeElement($siteTouristique);
            // set the owning side to null (unless already changed)
            if ($siteTouristique->getDestination() === $this) {
                $siteTouristique->setDestination(null);
            }
        }

        return $this;
    }

    public function getDestination(): ?string
    {
        return $this->destination;
    }

    public function setDestination(string $destination): self
    {
        $this->destination = $destination;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getAuteur(): ?string
    {
        return $this->auteur;
    }

    public function setAuteur(?string $auteur): self
    {
        $this->auteur = $auteur;

        return $this;
    }

    public function getFavoris(): ?bool
    {
        return $this->favoris;
    }

    public function setFavoris(?bool $favoris): self
    {
        $this->favoris = $favoris;

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(?int $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getAncienPrix(): ?int
    {
        return $this->ancienPrix;
    }

    public function setAncienPrix(?int $ancienPrix): self
    {
        $this->ancienPrix = $ancienPrix;

        return $this;
    }
}
