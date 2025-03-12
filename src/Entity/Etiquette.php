<?php

namespace App\Entity;

use App\Repository\EtiquetteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EtiquetteRepository::class)]
class Etiquette
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $libelle = null;

    #[ORM\ManyToOne(inversedBy: 'etiquettes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Projet $projet = null;

    /**
     * @var Collection<int, tache>
     */
    #[ORM\ManyToMany(targetEntity: tache::class, inversedBy: 'etiquettes')]
    private Collection $tache;

    public function __construct()
    {
        $this->tache = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): static
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getProjet(): ?projet
    {
        return $this->projet;
    }

    public function setProjet(?projet $projet): static
    {
        $this->projet = $projet;

        return $this;
    }

    /**
     * @return Collection<int, tache>
     */
    public function getTache(): Collection
    {
        return $this->tache;
    }

    public function addTache(tache $tache): static
    {
        if (!$this->tache->contains($tache)) {
            $this->tache->add($tache);
        }

        return $this;
    }

    public function removeTache(tache $tache): static
    {
        $this->tache->removeElement($tache);

        return $this;
    }
}
