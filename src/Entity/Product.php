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

    #[ORM\Column(length: 1000)]
    private ?string $product_name = null;

    #[ORM\Column]
    private ?int $stock = null;

    #[ORM\Column]
    private ?float $product_price = null;

    #[ORM\Column]
    private ?bool $product_status = null;

    #[ORM\Column(length: 5)]
    private ?string $size = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $import_date = null;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: OrderDetail::class, orphanRemoval: true)]
    private Collection $product_orderDetail;

    #[ORM\ManyToOne(inversedBy: 'products')]
    #[ORM\JoinColumn(nullable: false)]
    private ?category $cat = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    #[ORM\JoinColumn(nullable: false)]
    private ?brand $brand = null;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: ProductImage::class, orphanRemoval: true)]
    private Collection $productImages;

    public function __construct()
    {
        $this->product_orderDetail = new ArrayCollection();
        $this->productImages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProductName(): ?string
    {
        return $this->product_name;
    }

    public function setProductName(string $product_name): self
    {
        $this->product_name = $product_name;

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(int $stock): self
    {
        $this->stock = $stock;

        return $this;
    }

    public function getProductPrice(): ?float
    {
        return $this->product_price;
    }

    public function setProductPrice(float $product_price): self
    {
        $this->product_price = $product_price;

        return $this;
    }

    public function isProductStatus(): ?bool
    {
        return $this->product_status;
    }

    public function setProductStatus(bool $product_status): self
    {
        $this->product_status = $product_status;

        return $this;
    }

    public function getSize(): ?string
    {
        return $this->size;
    }

    public function setSize(string $size): self
    {
        $this->size = $size;

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

    public function getImportDate(): ?\DateTimeInterface
    {
        return $this->import_date;
    }

    public function setImportDate(\DateTimeInterface $import_date): self
    {
        $this->import_date = $import_date;

        return $this;
    }

    /**
     * @return Collection<int, OrderDetail>
     */
    public function getProductOrderDetail(): Collection
    {
        return $this->product_orderDetail;
    }

    public function addProductOrderDetail(OrderDetail $productOrderDetail): self
    {
        if (!$this->product_orderDetail->contains($productOrderDetail)) {
            $this->product_orderDetail->add($productOrderDetail);
            $productOrderDetail->setProduct($this);
        }

        return $this;
    }

    public function removeProductOrderDetail(OrderDetail $productOrderDetail): self
    {
        if ($this->product_orderDetail->removeElement($productOrderDetail)) {
            // set the owning side to null (unless already changed)
            if ($productOrderDetail->getProduct() === $this) {
                $productOrderDetail->setProduct(null);
            }
        }

        return $this;
    }

    public function getCat(): ?category
    {
        return $this->cat;
    }

    public function setCat(?category $cat): self
    {
        $this->cat = $cat;

        return $this;
    }

    public function getBrand(): ?brand
    {
        return $this->brand;
    }

    public function setBrand(?brand $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * @return Collection<int, ProductImage>
     */
    public function getProductImages(): Collection
    {
        return $this->productImages;
    }

    public function addProductImage(ProductImage $productImage): self
    {
        if (!$this->productImages->contains($productImage)) {
            $this->productImages->add($productImage);
            $productImage->setProduct($this);
        }

        return $this;
    }

    public function removeProductImage(ProductImage $productImage): self
    {
        if ($this->productImages->removeElement($productImage)) {
            // set the owning side to null (unless already changed)
            if ($productImage->getProduct() === $this) {
                $productImage->setProduct(null);
            }
        }

        return $this;
    }
}
