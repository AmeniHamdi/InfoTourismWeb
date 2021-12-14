<?php

namespace App\Entity;

use App\Repository\AssuranceRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Exception;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=AssuranceRepository::class)
 */
class Assurance
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank(message="Voiture est Obligatoire")
     * @ORM\ManyToOne(targetEntity="Voiture")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $idvoiture;

    /**
     * @Assert\NotBlank(message="date Debut est Obligatoire")
     * @var datetime|null
     * @ORM\Column(type="date")
     */
    public $dateDebut;

    /**
     * @Assert\NotBlank(message="date Fin est Obligatoire")
     * @Assert\Expression("value > this.dateDebut", message="date de debut doit étre avant la date fin")
     * @var datetime|null
     * @ORM\Column(type="date")
     */
    public $dateFin;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $createdBy = null;

    /**
     * @Assert\NotBlank(message="assigned To est Obligatoire")
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $assignedTo = null;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getDateDebut(): ?string
    {
        if ($this->dateDebut === null) {
            return null;
        }
        return $this->dateDebut->format('d/m/Y');
    }

    /**
     * @return string|null
     */
    public function getDateFin(): ?string
    {
        if ($this->dateFin === null) {
            return null;
        }
        return $this->dateFin->format('d/m/Y');
    }

    /**
     * @return string|null
     */
    public function getCreatedBy(): ?string
    {
        return $this->createdBy;
    }

    /**
     * @return string|null
     */
    public function getAssignedTo(): ?string
    {
        return $this->assignedTo;
    }

    /**
     * @param string $dateDebut
     * @throws Exception
     */
    public function setDateDebut(string $dateDebut): void
    {
        $this->dateDebut = new DateTime($dateDebut);
    }

    /**
     * @param string $dateFin
     * @throws Exception
     */
    public function setDateFin(string $dateFin): void
    {
        $this->dateFin = new DateTime($dateFin);
    }

    /**
     * @param string $createdBy
     */
    public function setCreatedBy(string $createdBy): void
    {
        $this->createdBy = $createdBy;
    }

    /**
     * @param string $assignedTo
     */
    public function setAssignedTo(string $assignedTo): void
    {
        $this->assignedTo = $assignedTo;
    }

    /**
     * @return mixed
     */
    public function getIdvoiture()
    {
        return $this->idvoiture;
    }

    /**
     * @param mixed $idvoiture
     */
    public function setIdvoiture($idvoiture): void
    {
        $this->idvoiture = $idvoiture;
    }
}
