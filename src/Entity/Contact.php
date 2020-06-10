<?php

namespace App\Entity;

use App\Repository\ContactRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ContactRepository::class)
 */
class Contact
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Customer::class, inversedBy="contacts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $customer;

    /**
     * @ORM\ManyToMany(targetEntity=Project::class, mappedBy="contacts", cascade={"persist"})
     */
    private $project;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Length(min="2", max="255")
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\Column(type="boolean")
     */
    private $sendAlert = false;

    public function __construct()
    {
        $this->project = new ArrayCollection();
    }

    public function __toString(): string
    {
        return sprintf('%s (%s)', $this->name ?? 'no name contact', $this->customer ?? 'No customer name');
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(?Customer $customer): self
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * @return Collection|Project[]
     */
    public function getProject(): Collection
    {
        return $this->project;
    }

    public function addProject(Project $project): self
    {
        if (!$this->project->contains($project)) {
            $this->project[] = $project;
        }

        return $this;
    }

    public function removeProject(Project $project): self
    {
        if ($this->project->contains($project)) {
            $this->project->removeElement($project);
        }

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getSendAlert(): ?bool
    {
        return $this->sendAlert;
    }

    public function setSendAlert(bool $sendAlert): self
    {
        $this->sendAlert = $sendAlert;

        return $this;
    }
}
