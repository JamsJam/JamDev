<?php

namespace App\Entity;

use App\Repository\ProjetsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProjetsRepository::class)]
class Projets
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(length: 255)]
    private ?string $lien = null;

    #[ORM\Column(length: 255)]
    private ?string $images = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    // #[ORM\ManyToMany(targetEntity: Technologie::class, mappedBy: 'projet')]
    // private Collection $technologies;

    #[ORM\ManyToOne(inversedBy: 'projets')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Categorie $categorie = null;

    #[ORM\ManyToMany(targetEntity: Technologie::class, inversedBy: 'projets')]
    private Collection $Technologie;

    public function __construct()
    {
        $this->Technologie = new ArrayCollection();
    }

    // public function __construct()
    // {
    //     $this->technologies = new ArrayCollection();
    // }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getLien(): ?string
    {
        return $this->lien;
    }

    public function setLien(string $lien): self
    {
        $this->lien = $lien;

        return $this;
    }

    public function getImages(): ?string
    {
        return $this->images;
    }

    public function setImages(string $images): self
    {
        $this->images = $images;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    // /**
    //  * @return Collection<int, Technologie>
    //  */
    // public function getTechnologies(): Collection
    // {
    //     return $this->technologies;
    // }

    // public function addTechnology(Technologie $technology): self
    // {
    //     if (!$this->technologies->contains($technology)) {
    //         $this->technologies->add($technology);
    //         $technology->addProjet($this);
    //     }

    //     return $this;
    // }

    // public function removeTechnology(Technologie $technology): self
    // {
    //     if ($this->technologies->removeElement($technology)) {
    //         $technology->removeProjet($this);
    //     }

    //     return $this;
    // }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * @return Collection<int, Technologie>
     */
    public function getTechnologie(): Collection
    {
        return $this->Technologie;
    }

    public function addTechnologie(Technologie $technologie): self
    {
        if (!$this->Technologie->contains($technologie)) {
            $this->Technologie->add($technologie);
        }

        return $this;
    }

    public function removeTechnologie(Technologie $technologie): self
    {
        $this->Technologie->removeElement($technologie);

        return $this;
    }
}
