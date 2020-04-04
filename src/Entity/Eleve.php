<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\OneToOne;
use Doctrine\ORM\Mapping\JoinColumn;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EleveRepository")
 */
class Eleve
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
    private $nom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $niveau;
    
    /**
     * Un eleve a un emprunt.
     * @OneToOne(targetEntity="Emprunt", mappedBy="eleve")
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

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getNiveau(): ?string
    {
        return $this->niveau;
    }

    public function setNiveau(?string $niveau): self
    {
        $this->niveau = $niveau;

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
