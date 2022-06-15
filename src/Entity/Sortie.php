<?php

namespace App\Entity;

use App\Repository\SortieRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SortieRepository::class)
 */
class Sortie
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=0)
     */
    private $qtS;

    /**
     * @ORM\Column(type="date")
     */
    private $dateS;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=0)
     */
    private $prixS;

    /**
     * @ORM\ManyToOne(targetEntity=Produit::class, inversedBy="sorties")
     * @ORM\JoinColumn(nullable=false)
     */
    private $produit;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="sorties")
     */
    private $user;

   

    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQtS(): ?string
    {
        return $this->qtS;
    }

    public function setQtS(string $qtS): self
    {
        $this->qtS = $qtS;

        return $this;
    }

    public function getDateS(): ?\DateTimeInterface
    {
        return $this->dateS;
    }

    public function setDateS(\DateTimeInterface $dateS): self
    {
        $this->dateS = $dateS;

        return $this;
    }

    public function getPrixS(): ?string
    {
        return $this->prixS;
    }

    public function setPrixS(string $prixS): self
    {
        $this->prixS = $prixS;

        return $this;
    }

    public function getProduit(): ?Produit
    {
        return $this->produit;
    }

    public function setProduit(?Produit $produit): self
    {
        $this->produit = $produit;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

  
}
