<?php

namespace App\Entity;

use App\Repository\TransportRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=TransportRepository::class)
 */
class Transport
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank(message="type est Obligatoire")
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $type = null;

    /**
     * @Assert\NotBlank(message="lieu est Obligatoire")
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $lieu = null;

    /**
     * @Assert\NotBlank(message="heure de disponibilité est Obligatoire")
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $heureDisponibilite = null;

    /**
     * @Assert\NotBlank(message="capacité est Obligatoire")
     * @var int
     * @ORM\Column(type="integer")
     */
    private $capacite = null;

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
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @return string|null
     */
    public function getLieu(): ?string
    {
        return $this->lieu;
    }

    /**
     * @return string|null
     */
    public function getHeureDisponibilite(): ?string
    {
        return $this->heureDisponibilite;
    }

    /**
     * @return int|null
     */
    public function getCapacite(): ?int
    {
        return $this->capacite;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @param string $lieu
     */
    public function setLieu(string $lieu): void
    {
        $this->lieu = $lieu;
    }

    /**
     * @param string $heureDisponibilite
     */
    public function setHeureDisponibilite(string $heureDisponibilite): void
    {
        $this->heureDisponibilite = $heureDisponibilite;
    }

    /**
     * @param int $capacite
     */
    public function setCapacite(int $capacite): void
    {
        $this->capacite = $capacite;
    }
}
