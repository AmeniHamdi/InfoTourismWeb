<?php

namespace App\Entity;

use App\Repository\LocationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=LocationRepository::class)
 */
class Location
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $idUser;

    /**
     * @ORM\ManyToOne(targetEntity="Voiture")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $idVoiture;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @Assert\NotBlank(message="nombre de jours est Obligatoire")
     * @var int
     * @ORM\Column(type="integer")
     */
    private $nbrJours = null;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $prixTotal = null;

    /**
     * @return User
     */
    public function getIdUser(): User
    {
        return $this->idUser;
    }

    /**
     * @param User $idUser
     */
    public function setIdUser(User $idUser): void
    {
        $this->idUser = $idUser;
    }

    /**
     * @return int
     */
    public function getIdVoiture(): int
    {
        return $this->idVoiture->getId();
    }

    /**
     * @param Voiture $idVoiture
     */
    public function setIdVoiture(Voiture $idVoiture): void
    {
        $this->idVoiture = $idVoiture;
    }

    /**
     * @return int
     */
    public function getNbrJours(): ?int
    {
        return $this->nbrJours;
    }

    /**
     * @param int $nbrJours
     */
    public function setNbrJours(int $nbrJours): void
    {
        $this->nbrJours = $nbrJours;
    }

    /**
     * @return int
     */
    public function getPrixTotal(): ?int
    {
        return $this->prixTotal;
    }

    /**
     * @param int $prixTotal
     */
    public function setPrixTotal(int $prixTotal): void
    {
        $this->prixTotal = $prixTotal;
    }
}
