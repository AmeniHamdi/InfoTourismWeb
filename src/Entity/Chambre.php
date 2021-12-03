<?php

namespace App\Entity;

use App\Repository\ChambreRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ChambreRepository::class)
 */
class Chambre
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer",length=11, nullable=true)
     * @Assert\NotBlank(message="ajouter le nombre de lit")
     */
    private $nlits;
    /**
     * @ORM\Column(type="integer")
     */
    private $rate;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank (message="ajouter le prix")
     */
    private $prix;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank (message="ajouter le numéro de chambre")
     */
    private $numero;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank (message="ajouter le numéro d'étage")
     */
    private $etage;

    /**
     * @ORM\Column(type="integer")
     */
    private $id_h;

    /**
     * @ORM\ManyToOne(targetEntity=Hotel::class, inversedBy="chambres")
     *  @Assert\Valid()
     */
    private $hotel;

    /**
     * @return mixed
     */
    public function getNlits()
    {
        return $this->nlits;
    }

    /**
     * @param mixed $nlits
     */
    public function setNlits($nlits): void
    {
        $this->nlits = $nlits;
    }


    public function getId(): ?int
    {
        return $this->id;
    }


    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getNumero(): ?int
    {
        return $this->numero;
    }

    public function setNumero(int $numero): self
    {
        $this->numero = $numero;

        return $this;
    }

    public function getEtage(): ?int
    {
        return $this->etage;
    }


    public function getRate(): ?int
    {
        return $this->rate;
    }


    public function setRate($rate): void
    {
        $this->rate = $rate;
    }

    public function setEtage(int $etage): self
    {
        $this->etage = $etage;

        return $this;
    }

    public function getIdH(): ?int
    {
        return $this->id_h;
    }

    public function setIdH(int $id_h): self
    {
        $this->id_h = $id_h;

        return $this;
    }

    public function getHotel(): ?Hotel
    {
        return $this->hotel;
    }

    public function setHotel(?Hotel $hotel): self
    {
        $this->hotel = $hotel;

        return $this;
    }


}