<?php

namespace App\Entity;

use App\Repository\PostRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;


/**
 * @ORM\Entity(repositoryClass=PostRepository::class)
 */
class Post
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * *@Assert\NotBlank(message="Remplir Titre ou essayer une autre fois ")
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     * *@Assert\NotBlank(message="Remplir Description ou essayer une autre fois ")
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     */
    private $views;

    /**
     * @return mixed
     */
    public function getViews()
    {
        return $this->views;
    }

    /**
     * @param mixed $views
     */
    public function setViews($views): void
    {
        $this->views = $views;
    }

    /**
     * @ORM\Column(name="photo", type="string", length=500)
     * @Assert\File(maxSize="500k", mimeTypes={"image/jpeg", "image/jpg", "image/png", "image/GIF"})
     * *@Assert\NotBlank(message="Choisir photo ou essayer une autre fois ")
     */
    private $photo;

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column (type="datetime", name="postdate")
     */
    private $postdate;

    /**
     * @ORM\OneToMany(targetEntity=Postcomment::class, mappedBy="post",cascade={"all"},orphanRemoval=true)
     */
    private $postcomments;



    public function getPostdate(): ?\DateTimeInterface
    {
        return $this->postdate;
    }




    public function __construct()
    {
        $this->postcomments = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPhoto()
    {
        return $this->photo;
    }

    public function setPhoto($photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * @return Collection|Postcomment[]
     */
    public function getPostcomments(): Collection
    {
        return $this->postcomments;
    }

    public function addPostcomment(Postcomment $postcomment): self
    {
        if (!$this->postcomments->contains($postcomment)) {
            $this->postcomments[] = $postcomment;
            $postcomment->setPost($this);
        }

        return $this;
    }

    public function removePostcomment(Postcomment $postcomment): self
    {
        if ($this->postcomments->removeElement($postcomment)) {
            // set the owning side to null (unless already changed)
            if ($postcomment->getPost() === $this) {
                $postcomment->setPost(null);
            }
        }

        return $this;
    }
}
