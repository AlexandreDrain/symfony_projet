<?php

namespace App\Entity;

use Cocur\Slugify\Slugify;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ServiceRepository")
 * @ORM\HasLifecycleCallbacks()
 * @Vich\Uploadable
 */
class Service
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $label;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $imageName;

    /**
     * @var File
     * @Vich\UploadableField(mapping="Image_du_produit", fileNameProperty="imageName")
     */
    private $imageFile;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="text", length=255)
     */
    private $descriptionService;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="services")
     */
    private $category;

    /**
     * @ORM\Column(type="string", length=128, unique=true)
     */
    private $slug;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="services")
     */
    private $publisher;

    /**
     * @ORM\PreUpdate()
     */
    public function refreshUpdatedAt()
    {
        $this->updatedAt = new \DateTime();
    }

    /**
     * @ORM\PrePersist()
     */
    public function refreshCreateddAt()
    {
        $this->createdAt = new \DateTime();
        $this->updateSlug();
    }

    /**
     * Met a jour le slug par rapport au name
     * @return Service
     */
    public function updateSlug(): self
    {
        // On récupère le slugger
        $slugify = new Slugify();
        // mise a jour du slug par rapport au name
        $this->slug = $slugify->slugify($this->label);
        // Pour le chainage
        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function setImageName(?string $imageName = null): self
    {
        $this->imageName = $imageName;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getDescriptionService(): ?string
    {
        return $this->descriptionService;
    }

    public function setDescriptionService(string $descriptionService): self
    {
        $this->descriptionService = $descriptionService;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return File
     */
    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }
    /**
     * @param File $imageFile
     * @throws \Exception
     */
    public function setImageFile(?File $imageFile = null): void
    {
        if (!is_null($imageFile)) {
            $this->updatedAt = new \DateTimeImmutable();
        }
        $this->imageFile = $imageFile;
    }

    public function getPublisher(): ?User
    {
        return $this->publisher;
    }

    public function setPublisher(?User $publisher): self
    {
        $this->publisher = $publisher;

        return $this;
    }
}
