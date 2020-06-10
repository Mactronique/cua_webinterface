<?php

namespace App\Entity;

use App\Repository\SecurityIssueRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SecurityIssueRepository::class)
 * @ORM\Table(name="security")
 * @ORM\HasLifecycleCallbacks()
 */
class SecurityIssue
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @#ORM\Column(type="string", length=50)
     * @ORM\ManyToOne(targetEntity="Project", inversedBy="securityIssues")
     * @ORM\JoinColumn(name="project", referencedColumnName="code")
     */
    private $project;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $library;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $version;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $state;

    /**
     * @ORM\Column(type="text")
     */
    private $details;

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

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    private function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getDetails(): ?string
    {
        return $this->details;
    }

    public function setDetails(string $details): self
    {
        $this->details = $details;

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
