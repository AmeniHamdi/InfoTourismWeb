<?php

namespace App\Entity;

use App\Repository\AssuranceRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
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
     * @var datetime|null
     * @ORM\Column(type="datetime")
     */
    private $dateDebut;

    /**
     * @var datetime|null
     * @ORM\Column(type="datetime")
     */
    private $dateFin;

    /**
    *@Assert\NotBlank(message="The Creator  is required";)
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $createdBy = null;

    /**
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
        return $this->dateDebut->format('Y-m-d') ?? null;
    }

    /**
     * @return string|null
     */
    public function getDateFin(): ?string
    {
        if ($this->dateFin === null) {
            return null;
        }
        return $this->dateFin->format('Y-m-d') ?? null;
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
     * @param DateTime $dateDebut
     */
    public function setDateDebut(DateTime $dateDebut): void
    {
        $this->dateDebut = $dateDebut;
    }

    /**
     * @param DateTime $dateFin
     */
    public function setDateFin(DateTime $dateFin): void
    {
        $this->dateFin = $dateFin;
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
}
