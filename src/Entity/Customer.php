<?php

namespace App\Entity;

use App\Repository\CustomerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CustomerRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Customer
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
    private $name;

    /**
     * @var \DateTime
     * @ORM\Column(name="added_at", type="datetime")
     */
    private $addedAt;

    /**
     * @var null|\DateTime
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity=Project::class, mappedBy="customer")
     */
    private $projects;

    /**
     * @ORM\OneToMany(targetEntity=Contact::class, mappedBy="customer", cascade={"remove", "persist"}, orphanRemoval=true)
     */
    private $contacts;

    public function __construct()
    {
        $this->projects = new ArrayCollection();
        $this->addedAt = new \DateTime();
        $this->contacts = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->name ?? 'customer #'.$this->id;
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection|Project[]
     */
    public function getProjects(): Collection
    {
        return $this->projects;
    }

    public function addProject(Project $project): self
    {
        if (!$this->projects->contains($project)) {
            $this->projects[] = $project;
            $project->setCustomer($this);
        }

        return $this;
    }

    public function removeProject(Project $project): self
    {
        if ($this->projects->contains($project)) {
            $this->projects->removeElement($project);
            // set the owning side to null (unless already changed)
            if ($project->getCustomer() === $this) {
                $project->setCustomer(null);
            }
        }

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getAddedAt(): \DateTime
    {
        return $this->addedAt;
    }

    /**
     * @param \DateTime $addedAt
     * @return Customer
     */
    private function setAddedAt(\DateTime $addedAt): Customer
    {
        $this->addedAt = $addedAt;
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime|null $updatedAt
     * @return Customer
     */
    private function setUpdatedAt(?\DateTime $updatedAt): Customer
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     * @ORM\PrePersist()
     */
    public function prePersist()
    {
        $this->addedAt = new \DateTime();
    }

    /**
     * @ORM\PreUpdate()
     */
    public function preUpdate()
    {
        $this->updatedAt = new \DateTime();
    }

    /**
     * @return Collection|Contact[]
     */
    public function getContacts(): Collection
    {
        return $this->contacts;
    }

    public function addContact(Contact $contact): self
    {
        if (!$this->contacts->contains($contact)) {
            $this->contacts[] = $contact;
            $contact->setCustomer($this);
        }

        return $this;
    }

    public function removeContact(Contact $contact): self
    {
        if ($this->contacts->contains($contact)) {
            $this->contacts->removeElement($contact);
            // set the owning side to null (unless already changed)
            if ($contact->getCustomer() === $this) {
                $contact->setCustomer(null);
            }
        }

        return $this;
    }
}
