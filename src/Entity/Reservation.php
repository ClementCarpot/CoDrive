<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;


/**
 * @ORM\Entity
 */
class Reservation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Utilisateur", inversedBy="reservations")
     */
    private $passager;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Annonce", inversedBy="reservations")
     */
    private $annonce;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Commentaire", mappedBy="reservation")
     */
    private $commentaires;

    public function __construct()
    {
        // ...
        $this->commentaires = new ArrayCollection();
    }

    /**
     * @return Collection|Commentaire[]
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPassager(): ?Utilisateur
    {
        return $this->passager;
    }

    public function setPassager(?Utilisateur $passager): self
    {
        $this->passager = $passager;

        return $this;
    }

    public function getAnnonce(): ?Annonce
    {
        return $this->annonce;
    }

    public function setAnnonce(?Annonce $annonce): self
    {
        $this->annonce = $annonce;

        return $this;
    }
}
