<?php

namespace App\Entity;

use App\Repository\ProjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * @ORM\Entity(repositoryClass=ProjectRepository::class)
 * @ORM\Table(name="projects")
 * @ORM\HasLifecycleCallbacks()
 */
class Project
{
    public const STRATEGY_REMOVE = 'remove';
    public const STRATEGY_HASH = 'hash';

    /**
     * @var null|string
     *
     * @ORM\Id()
     * @ORM\Column(type="string", length=10)
     * @Assert\NotBlank()
     * @Assert\Length(min="1", max="10")
     */
    private $code;

    /**
     * @var null|Customer
     *
     * @ORM\ManyToOne(targetEntity=Customer::class, inversedBy="projects")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull()
     */
    private $customer;

    /**
     * @var null|string
     *
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank()
     * @Assert\Length(min="1", max="100")
     */
    private $name;

    /**
     * @var null|string
     *
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Length(min="1", max="255")
     */
    private $path;

    /**
     * @var null|string
     *
     * @ORM\Column(name="lock_path", type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Length(min="1", max="255")
     */
    private $lockPath = 'composer.lock';

    /**
     * @var null|string
     *
     * @ORM\Column(name="php_path", type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Length(min="1", max="255")
     */
    private $phpPath = 'php';

    /**
     * @var null|string
     *
     * @ORM\Column(name="private_dependencies", type="text", nullable=true)
     */
    private $privateDependencies;

    /**
     * @var null|string
     *
     * @ORM\Column(name="private_dependencies_strategy", type="string", length=10, nullable=true)
     */
    private $privateDependenciesStrategy = self::STRATEGY_REMOVE;

    /**
     * @var bool
     *
     * @ORM\Column(name="check_dependencies", type="boolean", nullable=true)
     */
    private $checkDependencies = true;

    /**
     * @var bool
     *
     * @ORM\Column(name="check_security", type="boolean", nullable=true)
     */
    private $checkSecurity = true;

    /**
     * @var null|\DateTime
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @var null|\DateTime
     * @ORM\Column(name="added_at", type="datetime")
     */
    private $addedAt;

    /**
     * @var bool
     *
     * @ORM\Column(name="enabled", type="boolean")
     */
    private $enabled = true;

    /**
     * @var array|ArrayCollection|Dependency[]
     *
     * @ORM\OneToMany(targetEntity=Dependency::class, mappedBy="project")
     */
    private $dependencies;

    /**
     * @var array|ArrayCollection|SecurityIssue[]
     *
     * @ORM\OneToMany(targetEntity=SecurityIssue::class, mappedBy="project")
     */
    private $securityIssues;

    /**
     * @var array|ArrayCollection|Contact[]
     *
     * @ORM\ManyToMany(targetEntity=Contact::class, mappedBy="project", cascade={"remove", "persist"})
     */
    private $contacts;

    public function __construct()
    {
        $this->dependencies = new ArrayCollection();
        $this->securityIssues = new ArrayCollection();
        $this->contacts = new ArrayCollection();
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(string $path): self
    {
        $this->path = $path;

        return $this;
    }

    public function getLockPath(): ?string
    {
        return $this->lockPath;
    }

    public function setLockPath(string $lockPath): self
    {
        $this->lockPath = $lockPath;

        return $this;
    }

    public function getPhpPath(): ?string
    {
        return $this->phpPath;
    }

    public function setPhpPath(string $phpPath): self
    {
        $this->phpPath = $phpPath;

        return $this;
    }

    public function getPrivateDependencies(): ?string
    {
        return $this->privateDependencies;
    }

    public function setPrivateDependencies(?string $privateDependencies): self
    {
        $this->privateDependencies = $privateDependencies;

        return $this;
    }

    public function getPrivateDependenciesStrategy(): ?string
    {
        return $this->privateDependenciesStrategy;
    }

    public function setPrivateDependenciesStrategy(?string $privateDependenciesStrategy): self
    {
        $this->privateDependenciesStrategy = $privateDependenciesStrategy;

        return $this;
    }

    public function getCheckDependencies(): ?bool
    {
        return $this->checkDependencies;
    }

    public function setCheckDependencies(?bool $checkDependencies): self
    {
        $this->checkDependencies = $checkDependencies;

        return $this;
    }

    public function getCheckSecurity(): ?bool
    {
        return $this->checkSecurity;
    }

    public function setCheckSecurity(?bool $checkSecurity): self
    {
        $this->checkSecurity = $checkSecurity;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function getAddedAt(): ?\DateTimeInterface
    {
        return $this->addedAt;
    }

    public function isEnabled(): ?bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): self
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * @return Collection|Dependency[]
     */
    public function getDependencies(): Collection
    {
        return $this->dependencies;
    }

    public function addDependency(Dependency $dependency): self
    {
        if (!$this->dependencies->contains($dependency)) {
            $this->dependencies[] = $dependency;
            $dependency->setProject($this);
        }

        return $this;
    }

    public function removeDependency(Dependency $dependency): self
    {
        if ($this->dependencies->contains($dependency)) {
            $this->dependencies->removeElement($dependency);
            // set the owning side to null (unless already changed)
//            if ($dependency->getProject() === $this) {
//                $dependency->setProject(null);
//            }
        }

        return $this;
    }

    /**
     * @return Collection|SecurityIssue[]
     */
    public function getSecurityIssues(): Collection
    {
        return $this->securityIssues;
    }

    public function addProject(SecurityIssue $securityIssue): self
    {
        if (!$this->securityIssues->contains($securityIssue)) {
            $this->securityIssues[] = $securityIssue;
            $securityIssue->setProject($this);
        }

        return $this;
    }

    public function removeProject(SecurityIssue $securityIssue): self
    {
        if ($this->securityIssues->contains($securityIssue)) {
            $this->securityIssues->removeElement($securityIssue);
            // set the owning side to null (unless already changed)
//            if ($securityIssue->getProject() === $this) {
//                $securityIssue->setProject(null);
//            }
        }

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
            $contact->addProject($this);
        }

        return $this;
    }

    public function removeContact(Contact $contact): self
    {
        if ($this->contacts->contains($contact)) {
            $this->contacts->removeElement($contact);
            $contact->removeProject($this);
        }

        return $this;
    }

    /**
     * @Assert\Callback()
     */
    public function checkContact(ExecutionContextInterface $context, $payload)
    {
        if ($this->contacts->isEmpty() || $this->customer === null) {
            return;
        }
        foreach ($this->contacts as $key => $contact) {
            /** @var Contact $contact */
            if ($contact->getCustomer() !== $this->customer) {
                $context->buildViolation(
                    'The contact "%contact_name%" is not affected to this customer',
                    [
                        '%contact_name%' => $contact->__toString(),
                    ]
                )
                    ->atPath('contacts')
                    ->addViolation();
            }
        }
    }

    private function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    private function setAddedAt(\DateTimeInterface $addedAt): self
    {
        $this->addedAt = $addedAt;

        return $this;
    }
}
