<?php

namespace App\Entity;

use App\Repository\ActiviteRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ActiviteRepository::class)
 */
class Activite
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="champs vide")
     */
    private $destination;
    /**
     * @ORM\Column(type="string", length=1000)
     * @Assert\NotBlank(message="champs vide")
     */
    private $image;

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     */
    public function setImage($image): void
    {
        $this->image = $image;
    }


    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="champs vide")
     */
    private $activite;

    /**
     * @ORM\Column(type="date")
     */
    private $DateDepart;

    /**
     * @ORM\Column(type="date")
     */
    private $DateDarrivee;

    /**
     * @ORM\ManyToOne(targetEntity=Type::class, inversedBy="activite")
     */
    private $type;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDestination(): ?string
    {
        return $this->destination;
    }

    public function setDestination(string $destination): self
    {
        $this->destination = $destination;

        return $this;
    }

    public function getActivite(): ?string
    {
        return $this->activite;
    }

    public function setActivite(string $activite): self
    {
        $this->activite = $activite;

        return $this;
    }

    public function getDateDepart(): ?\DateTimeInterface
    {
        return $this->DateDepart;
    }

    public function setDateDepart(\DateTimeInterface $DateDepart): self
    {
        $this->DateDepart = $DateDepart;

        return $this;
    }

    public function getDateDarrivee(): ?\DateTimeInterface
    {
        return $this->DateDarrivee;
    }

    public function setDateDarrivee(\DateTimeInterface $DateDarrivee): self
    {
        $this->DateDarrivee = $DateDarrivee;

        return $this;
    }

    public function getType(): ?Type
    {
        return $this->type;
    }

    public function setType(?Type $type): self
    {
        $this->type = $type;

        return $this;
    }
}
