<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
class Client
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $lastname = null;

    #[ORM\Column(length: 255)]
    private ?string $firstname = null;

    #[ORM\ManyToOne(inversedBy: 'clients')]
    private ?ClientGroup $clientGroup = null;

    #[ORM\OneToMany(mappedBy: 'client', targetEntity: BookLoan::class, orphanRemoval: true)]
    private Collection $loans;

    public function __construct()
    {
        $this->loans = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getClientGroup(): ?ClientGroup
    {
        return $this->clientGroup;
    }

    public function setClientGroup(?ClientGroup $clientGroup): static
    {
        $this->clientGroup = $clientGroup;

        return $this;
    }

    /**
     * @return Collection<int, BookLoan>
     */
    public function getLoans(): Collection
    {
        return $this->loans;
    }

    public function addLoan(BookLoan $loan): static
    {
        if (!$this->loans->contains($loan)) {
            $this->loans->add($loan);
            $loan->setClient($this);
        }

        return $this;
    }

    public function removeLoan(BookLoan $loan): static
    {
        if ($this->loans->removeElement($loan)) {
            // set the owning side to null (unless already changed)
            if ($loan->getClient() === $this) {
                $loan->setClient(null);
            }
        }

        return $this;
    }
}
