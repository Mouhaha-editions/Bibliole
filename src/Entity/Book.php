<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookRepository::class)]
class Book
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(nullable: true)]
    private ?int $indexNumber = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $volume = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $shortDescription = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $barcode = null;

    #[ORM\ManyToMany(targetEntity: BookKeyword::class, mappedBy: 'books')]
    private Collection $keywords;

    #[ORM\OneToMany(mappedBy: 'book', targetEntity: BookLoan::class)]
    private Collection $loans;

    #[ORM\ManyToOne(inversedBy: 'books')]
    #[ORM\JoinColumn(nullable: true)]
    private ?BookCategory $category = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $cover = null;

    #[ORM\ManyToMany(targetEntity: BookAuthor::class, inversedBy: 'books', cascade: ['persist', 'remove'])]
    private Collection $authors;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $moreInformation = null;

    public function __construct()
    {
        $this->keywords = new ArrayCollection();
        $this->loans = new ArrayCollection();
        $this->authors = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getIndexNumber(): ?int
    {
        return $this->indexNumber;
    }

    public function setIndexNumber(int $indexNumber): static
    {
        $this->indexNumber = $indexNumber;

        return $this;
    }

    public function getVolume(): ?string
    {
        return $this->volume;
    }

    public function setVolume(?string $volume): static
    {
        $this->volume = $volume;

        return $this;
    }

    public function getShortDescription(): ?string
    {
        return $this->shortDescription;
    }

    public function setShortDescription(?string $shortDescription): static
    {
        $this->shortDescription = $shortDescription;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getBarcode(): ?string
    {
        return $this->barcode;
    }

    public function setBarcode(?string $barcode): static
    {
        $this->barcode = $barcode;

        return $this;
    }

    /**
     * @return Collection<int, BookKeyword>
     */
    public function getKeywords(): Collection
    {
        return $this->keywords;
    }

    public function addKeyword(BookKeyword $keyword): static
    {
        if (!$this->keywords->contains($keyword)) {
            $this->keywords->add($keyword);
            $keyword->addBook($this);
        }

        return $this;
    }

    public function removeKeyword(BookKeyword $keyword): static
    {
        if ($this->keywords->removeElement($keyword)) {
            $keyword->removeBook($this);
        }

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
            $loan->setBook($this);
        }

        return $this;
    }

    public function removeLoan(BookLoan $loan): static
    {
        if ($this->loans->removeElement($loan)) {
            // set the owning side to null (unless already changed)
            if ($loan->getBook() === $this) {
                $loan->setBook(null);
            }
        }

        return $this;
    }

    public function getCategory(): ?BookCategory
    {
        return $this->category;
    }

    public function setCategory(?BookCategory $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getAuthor(): ?BookAuthor
    {
        return $this->author;
    }

    public function setAuthor(?BookAuthor $author): static
    {
        $this->author = $author;

        return $this;
    }

    public function getCover(): ?string
    {
        return $this->cover;
    }

    public function setCover(?string $cover): static
    {
        $this->cover = $cover;

        return $this;
    }

    /**
     * @return Collection<int, BookAuthor>
     */
    public function getAuthors(): Collection
    {
        return $this->authors;
    }

    public function addAuthor(BookAuthor $author): static
    {
        if (!$this->authors->contains($author)) {
            $this->authors->add($author);
        }

        return $this;
    }

    public function removeAuthor(BookAuthor $author): static
    {
        $this->authors->removeElement($author);

        return $this;
    }

    public function getMoreInformation(): ?string
    {
        return $this->moreInformation;
    }

    public function setMoreInformation(?string $moreInformation): static
    {
        $this->moreInformation = $moreInformation;

        return $this;
    }
}
