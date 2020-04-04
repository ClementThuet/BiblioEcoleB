<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\OneToOne;
use Doctrine\ORM\Mapping\JoinColumn;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LivreRepository")
 */
class Livre
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
    private $titre;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $auteur;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $theme;

    /**
     * @ORM\Column(type="integer")
     */
    private $code;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbEmprunt;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateDernierEmprunt;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateDernierRetour;

    /**
     * @ORM\Column(type="boolean")
     */
    private $estEmprunte;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $bibliothequeOrigine;
    
    /**
     * Un livre a un emprunt.
     * @OneToOne(targetEntity="Emprunt", mappedBy="livre")
     * @JoinColumn(name="emprunt_id", referencedColumnName="id", onDelete="SET NULL")
    */
    private $emprunt;
    
    /**
     * @OneToOne(targetEntity="Image")
     */
    private $image;
    
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

    public function getAuteur(): ?string
    {
        return $this->auteur;
    }

    public function setAuteur(?string $auteur): self
    {
        $this->auteur = $auteur;

        return $this;
    }

    public function getTheme(): ?string
    {
        return $this->theme;
    }

    public function setTheme(?string $theme): self
    {
        $this->theme = $theme;

        return $this;
    }

    public function getCode(): ?int
    {
        return $this->code;
    }

    public function setCode(int $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getNbEmprunt(): ?int
    {
        return $this->nbEmprunt;
    }

    public function setNbEmprunt(int $nbEmprunt): self
    {
        $this->nbEmprunt = $nbEmprunt;

        return $this;
    }

    public function getDateDernierEmprunt(): ?\DateTimeInterface
    {
        return $this->dateDernierEmprunt;
    }

    public function setDateDernierEmprunt(?\DateTimeInterface $dateDernierEmprunt): self
    {
        $this->dateDernierEmprunt = $dateDernierEmprunt;

        return $this;
    }

    public function getDateDernierRetour(): ?\DateTimeInterface
    {
        return $this->dateDernierRetour;
    }

    public function setDateDernierRetour(?\DateTimeInterface $dateDernierRetour): self
    {
        $this->dateDernierRetour = $dateDernierRetour;

        return $this;
    }

    public function getEstEmprunte(): ?bool
    {
        return $this->estEmprunte;
    }

    public function setEstEmprunte(bool $estEmprunte): self
    {
        $this->estEmprunte = $estEmprunte;

        return $this;
    }

    public function getBibliothequeOrigine(): ?string
    {
        return $this->bibliothequeOrigine;
    }

    public function setBibliothequeOrigine(?string $bibliothequeOrigine): self
    {
        $this->bibliothequeOrigine = $bibliothequeOrigine;

        return $this;
    }
    
    public function getEmprunt() {
        return $this->emprunt ;
    }
    
    public function setEmprunt($emprunt) {
        $this->emprunt = $emprunt;
    }
    
    public function getImage()
    {
        return $this->image;
    }
    
    public function setImage($image) {
        $this->image = $image;
    }
}
