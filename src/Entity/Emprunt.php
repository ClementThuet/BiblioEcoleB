<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToOne;
use Doctrine\ORM\Mapping\JoinColumn;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EmpruntRepository")
 */
class Emprunt
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateEmprunt;

    /**
     * @ORM\Column(type="datetime",nullable=true)
     */
    private $dateRetour;

    /**
     * Un emprunt a UN livre.
     * @OneToOne(targetEntity="Livre", inversedBy="emprunt")
     */
    private $livre;
    
    /**
     * Un emprunt a UN élève.
     * @OneToOne(targetEntity="Eleve", inversedBy="emprunt")
     */
    private $eleve;
    
    public function getId(): ?int
    {
        return $this->id;
    }
    function getDateEmprunt() {
        return $this->dateEmprunt;
    }

    function getDateRetour() {
        return $this->dateRetour;
    }

    function getLivre() {
        return $this->livre;
    }

    function getEleve() {
        return $this->eleve;
    }

    function setDateEmprunt($dateEmprunt) {
        $this->dateEmprunt = $dateEmprunt;
    }

    function setDateRetour($dateRetour) {
        $this->dateRetour = $dateRetour;
    }

    function setLivre($livre) {
        $this->livre = $livre;
    }

    function setEleve($eleve) {
        $this->eleve = $eleve;
    }
}
