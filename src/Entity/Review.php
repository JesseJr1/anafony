<?php

namespace App\Entity;

use App\Entity\Rate;
use App\Repository\ReviewRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReviewRepository::class)]
class Review
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\ManyToOne(inversedBy: 'reviews')]
    private ?Product $product = null;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'replies')]
    private ?self $parent = null;

    #[ORM\OneToMany(mappedBy: 'parent', targetEntity: self::class)]
    private Collection $replies;

    #[ORM\OneToMany(mappedBy: 'review', targetEntity: Rate::class)]
    private Collection $reviewProduct;

    #[ORM\OneToMany(mappedBy: 'review', targetEntity: Rate::class)]
    private Collection $rateProduct;

    public function __construct()
    {
        $this->replies = new ArrayCollection();
        $this->reviewProduct = new ArrayCollection();
        $this->rateProduct = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

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

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(?self $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getReplies(): Collection
    {
        return $this->replies;
    }

    public function addReply(self $reply): self
    {
        if (!$this->replies->contains($reply)) {
            $this->replies->add($reply);
            $reply->setParent($this);
        }

        return $this;
    }

    public function removeReply(self $reply): self
    {
        if ($this->replies->removeElement($reply)) {
            // set the owning side to null (unless already changed)
            if ($reply->getParent() === $this) {
                $reply->setParent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Rate>
     */
    public function getReviewProduct(): Collection
    {
        return $this->reviewProduct;
    }

    public function addReviewProduct(Rate $reviewProduct): self
    {
        if (!$this->reviewProduct->contains($reviewProduct)) {
            $this->reviewProduct->add($reviewProduct);
            $reviewProduct->setReview($this);
        }

        return $this;
    }

    public function removeReviewProduct(Rate $reviewProduct): self
    {
        if ($this->reviewProduct->removeElement($reviewProduct)) {
            // set the owning side to null (unless already changed)
            if ($reviewProduct->getReview() === $this) {
                $reviewProduct->setReview(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Rate>
     */
    public function getRateProduct(): Collection
    {
        return $this->rateProduct;
    }

    public function addRateProduct(Rate $rateProduct): self
    {
        if (!$this->rateProduct->contains($rateProduct)) {
            $this->rateProduct->add($rateProduct);
            $rateProduct->setReview($this);
        }

        return $this;
    }

    public function removeRateProduct(Rate $rateProduct): self
    {
        if ($this->rateProduct->removeElement($rateProduct)) {
            // set the owning side to null (unless already changed)
            if ($rateProduct->getReview() === $this) {
                $rateProduct->setReview(null);
            }
        }

        return $this;
    }
}
