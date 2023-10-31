<?php

namespace App\Entity;

use App\Repository\FichierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FichierRepository::class)]
class Fichier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'fichiers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $proprietaire = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\ManyToMany(targetEntity: Categorie::class, inversedBy: 'fichiers')]
    private Collection $categories;

    #[ORM\OneToMany(mappedBy: 'fichier', targetEntity: Telecharger::class, orphanRemoval: true)]
    private Collection $telechargers;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->telechargers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProprietaire(): ?User
    {
        return $this->proprietaire;
    }

    public function setProprietaire(?User $proprietaire): static
    {
        $this->proprietaire = $proprietaire;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection<int, Categorie>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Categorie $category): static
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
        }

        return $this;
    }

    public function removeCategory(Categorie $category): static
    {
        $this->categories->removeElement($category);

        return $this;
    }

    /**
     * @return Collection<int, Telecharger>
     */
    public function getTelechargers(): Collection
    {
        return $this->telechargers;
    }

    public function addTelecharger(Telecharger $telecharger): static
    {
        if (!$this->telechargers->contains($telecharger)) {
            $this->telechargers->add($telecharger);
            $telecharger->setFichier($this);
        }

        return $this;
    }

    public function removeTelecharger(Telecharger $telecharger): static
    {
        if ($this->telechargers->removeElement($telecharger)) {
            // set the owning side to null (unless already changed)
            if ($telecharger->getFichier() === $this) {
                $telecharger->setFichier(null);
            }
        }

        return $this;
    }
}
