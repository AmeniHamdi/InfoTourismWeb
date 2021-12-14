<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ArticleRepository::class)
 */
class Article
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $DesciptionAr;

    /**
     * @ORM\Column(type="string", length=1000)
     */
    private $Image;

    /**
     * @ORM\Column(type="integer")
     */
    private $Nombrevue;

    /**
     * @ORM\Column(type="boolean")
     */
    private $Enabled;

    /**
     * @ORM\OneToMany(targetEntity=Commentaire::class, mappedBy="Article",cascade={"all"},orphanRemoval=true)
     */
    private $commentaire;

    public function __construct()
    {
        $this->commentaire = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDesciptionAr(): ?string
    {
        return $this->DesciptionAr;
    }

    public function setDesciptionAr(string $DesciptionAr): self
    {
        $this->DesciptionAr = $DesciptionAr;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->Image;
    }

    public function setImage(string $Image): self
    {
        $this->Image = $Image;

        return $this;
    }

    public function getNombrevue(): ?int
    {
        return $this->Nombrevue;
    }

    public function setNombrevue(int $Nombrevue): self
    {
        $this->Nombrevue = $Nombrevue;

        return $this;
    }
    /**
     * @return Collection|Commentaire[]
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaire $commentaire): self
    {
        if (!$this->commentares->contains($commentaire)) {
            $this->commentares[] = $commentaire;
            $commentaire->setCommentaire($this);
        }

        return $this;
    }

    public function removeStudent(Student $commentaire): self
    {
        if ($this->commentares->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getCommentaire() === $this) {
                $commentaire->setCommentaire(null);
            }
        }

        return $this;
    }

    public function getEnabled(): ?bool
    {
        return $this->Enabled;
    }

    public function setEnabled(bool $Enabled): self
    {
        $this->Enabled = $Enabled;

        return $this;
    }
}
