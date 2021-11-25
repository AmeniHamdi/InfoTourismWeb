<?php

namespace App\Entity;

use App\Repository\VoitureRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Exception;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=VoitureRepository::class)
 */
class Voiture
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string|null
     * @ORM\Column(type="string",nullable=true)
     */
    private $image = null;

    /**
     * @Assert\NotBlank(message="matricule est Obligatoire")
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $matricule = null;

    /**
     * @Assert\NotBlank(message="modele est Obligatoire")
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $modele = null;

    /**
     * @Assert\NotBlank(message="prix est Obligatoire")
     * @var int
     * @ORM\Column(type="integer")
     */
    private $prix;

    /**
     * @Assert\NotBlank(message="nombre de jour est Obligatoire")
     * @var int
     * @ORM\Column(type="integer")
     */
    private $nbrJours;

    /**
     * @Assert\NotBlank(message="date de reservation est Obligatoire")
     * @var datetime|null
     * @ORM\Column(type="date")
     */
    private $dateReservation;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getMatricule(): ?string
    {
        return $this->matricule;
    }

    /**
     * @return string|null
     */
    public function getModele(): ?string
    {
        return $this->modele;
    }

    /**
     * @return int|null
     */
    public function getPrix(): ?int
    {
        return $this->prix;
    }

    /**
     * @return int|null
     */
    public function getNbrJours(): ?int
    {
        return $this->nbrJours;
    }

    /**
     * @return string|null
     */
    public function getDateReservation(): ?string
    {
        if ($this->dateReservation === null) {
            return null;
        }
        return $this->dateReservation->format('Y-m-d');
    }

    /**
     * @param string $matricule
     */
    public function setMatricule(string $matricule): void
    {
        $this->matricule = $matricule;
    }

    /**
     * @param string $modele
     */
    public function setModele(string $modele): void
    {
        $this->modele = $modele;
    }

    /**
     * @param int $prix
     */
    public function setPrix(int $prix): void
    {
        $this->prix = $prix;
    }

    /**
     * @param int $nbrJours
     */
    public function setNbrJours(int $nbrJours): void
    {
        $this->nbrJours = $nbrJours;
    }

    /**
     * @param string $dateReservation
     * @throws Exception
     */
    public function setDateReservation(string $dateReservation): void
    {
        $this->dateReservation = new DateTime($dateReservation);
    }

    public function __toString()
    {
        return (string)$this->matricule;
    }

    /**
     * @return string|null
     */
    public function getImage(): ?string
    {
        return $this->image;
    }

    /**
     * @param string|null $image
     */
    public function setImage(?string $image): void
    {
        $this->image = $image;
    }
}