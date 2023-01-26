<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?float $price = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $manual = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Category $category = null;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: ProductPicture::class, orphanRemoval: true)]
    private Collection $picture;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: Rate::class, orphanRemoval: true)]
    private Collection $productRates;

    public function __construct()
    {
        $this->picture = new ArrayCollection();
        $this->productRates = new ArrayCollection();
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

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getManual(): ?string
    {
        return $this->manual;
    }

    public function setManual(?string $manual): self
    {
        $this->manual = $manual;

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

    /**
     * @return Collection<int, ProductPicture>
     */
    public function getPicture(): Collection
    {
        return $this->picture;
    }

    public function addPicture(ProductPicture $picture): self
    {
        if (!$this->picture->contains($picture)) {
            $this->picture->add($picture);
            $picture->setProduct($this);
        }

        return $this;
    }

    public function removePicture(ProductPicture $picture): self
    {
        if ($this->picture->removeElement($picture)) {
            // set the owning side to null (unless already changed)
            if ($picture->getProduct() === $this) {
                $picture->setProduct(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Rate>
     */
    public function getProductRates(): Collection
    {
        return $this->productRates;
    }

    public function addProductRate(Rate $productRate): self
    {
        if (!$this->productRates->contains($productRate)) {
            $this->productRates->add($productRate);
            $productRate->setProduct($this);
        }

        return $this;
    }

    public function removeProductRate(Rate $productRate): self
    {
        if ($this->productRates->removeElement($productRate)) {
            // set the owning side to null (unless already changed)
            if ($productRate->getProduct() === $this) {
                $productRate->setProduct(null);
            }
        }

        return $this;
    }
}
