<?php

namespace App\Entity;

use App\Repository\TechnologieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TechnologieRepository::class)]
class Technologie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $technologie = null;

    #[ORM\ManyToMany(targetEntity: Projets::class, inversedBy: 'technologies')]
    private Collection $projet;

    public function __construct()
    {
        $this->projet = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTechnologie(): ?string
    {
        return $this->technologie;
    }

    public function setTechnologie(string $technologie): self
    {
        $this->technologie = $technologie;

        return $this;
    }

    /**
     * @return Collection<int, Projets>
     */
    public function getProjet(): Collection
    {
        return $this->projet;
    }

    public function addProjet(Projets $projet): self
    {
        if (!$this->projet->contains($projet)) {
            $this->projet->add($projet);
        }

        return $this;
    }

    public function removeProjet(Projets $projet): self
    {
        $this->projet->removeElement($projet);

        return $this;
    }
}
