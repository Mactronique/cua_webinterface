<?php

namespace App\Entity;

use App\Repository\DependencyRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DependencyRepository::class)
 * @ORM\Table(name="dependencies")
 * @ORM\HasLifecycleCallbacks()
 */
class Dependency
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @#ORM\Column(type="string", length=50)
     * @ORM\ManyToOne(targetEntity="Project", inversedBy="dependencies")
     * @ORM\JoinColumn(name="project", referencedColumnName="code")
     */
    private $project;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $library;

    /**
     * @ORM\Column(type="string", length=250)
     */
    private $version;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $state;

    /**
     * @ORM\Column(type="string", length=250, nullable=true)
     */
    private $to_library;

    /**
     * @ORM\Column(type="string", length=250, nullable=true)
     */
    private $to_version;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $deprecated;

    /**
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updatedAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProject(): ?string
    {
        return $this->project;
    }

    public function setProject(string $project): self
    {
        $this->project = $project;

        return $this;
    }

    public function getLibrary(): ?string
    {
        return $this->library;
    }

    public function setLibrary(string $library): self
    {
        $this->library = $library;

        return $this;
    }

    public function getVersion(): ?string
    {
        return $this->version;
    }

    public function setVersion(string $version): self
    {
        $this->version = $version;

        return $this;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(string $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function getToLibrary(): ?string
    {
        return $this->to_library;
    }

    public function setToLibrary(?string $to_library): self
    {
        $this->to_library = $to_library;

        return $this;
    }

    public function getToVersion(): ?string
    {
        return $this->to_version;
    }

    public function setToVersion(?string $to_version): self
    {
        $this->to_version = $to_version;

        return $this;
    }

    public function getDeprecated(): ?bool
    {
        return $this->deprecated;
    }

    public function setDeprecated(?bool $deprecated): self
    {
        $this->deprecated = $deprecated;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    private function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @ORM\PreUpdate()
     * @ORM\PrePersist()
     */
    public function preUpdate()
    {
        $this->updatedAt=new \DateTime();
    }
}
