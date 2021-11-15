<?php

namespace App\Entity;

use App\Repository\TransportRepository;
use Doctrine\ORM\Mapping as ORM;

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
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $lieu;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $heureDisponibilite;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $capacite;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getLieu(): string
    {
        return $this->lieu;
    }

    /**
     * @return string
     */
    public function getHeureDisponibilite(): string
    {
        return $this->heureDisponibilite;
    }

    /**
     * @return int
     */
    public function getCapacite(): int
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
