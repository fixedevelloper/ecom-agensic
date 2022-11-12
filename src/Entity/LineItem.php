<?php

namespace App\Entity;

use App\Repository\LineItemRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LineItemRepository::class)]
class LineItem
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(nullable: true)]
    private ?int $variation_id = null;

    #[ORM\Column]
    private ?int $quantity = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $tax_class = null;

    #[ORM\Column(nullable: true)]
    private ?float $subtotal = null;

    #[ORM\Column(nullable: true)]
    private ?float $subtotal_tax = null;

    #[ORM\Column(nullable: true)]
    private ?float $total = null;

    #[ORM\Column(nullable: true)]
    private ?float $total_tax = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $sku = null;

    #[ORM\Column(nullable: true)]
    private ?float $price = null;

    #[ORM\ManyToMany(targetEntity: MetaData::class)]
    private Collection $meta_data;

    #[ORM\ManyToOne(inversedBy: 'line_items')]
    private ?Order $order_line = null;

    #[ORM\ManyToOne(inversedBy: 'line_items')]
    private ?Cart $cart = null;

    #[ORM\ManyToOne]
    private ?Product $product = null;

    public function __construct()
    {
        $this->meta_data = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }


    public function getVariationId(): ?int
    {
        return $this->variation_id;
    }

    public function setVariationId(?int $variation_id): self
    {
        $this->variation_id = $variation_id;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getTaxClass(): ?string
    {
        return $this->tax_class;
    }

    public function setTaxClass(?string $tax_class): self
    {
        $this->tax_class = $tax_class;

        return $this;
    }

    public function getSubtotal(): ?float
    {
        return $this->subtotal;
    }

    public function setSubtotal(?float $subtotal): self
    {
        $this->subtotal = $subtotal;

        return $this;
    }

    public function getSubtotalTax(): ?float
    {
        return $this->subtotal_tax;
    }

    public function setSubtotalTax(?float $subtotal_tax): self
    {
        $this->subtotal_tax = $subtotal_tax;

        return $this;
    }

    public function getTotal(): ?float
    {
        return $this->total;
    }

    public function setTotal(?float $total): self
    {
        $this->total = $total;

        return $this;
    }

    public function getTotalTax(): ?float
    {
        return $this->total_tax;
    }

    public function setTotalTax(?float $total_tax): self
    {
        $this->total_tax = $total_tax;

        return $this;
    }

    public function getSku(): ?string
    {
        return $this->sku;
    }

    public function setSku(?string $sku): self
    {
        $this->sku = $sku;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(?float $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return Collection<int, MetaData>
     */
    public function getMetaData(): Collection
    {
        return $this->meta_data;
    }

    public function addMetaData(MetaData $metaData): self
    {
        if (!$this->meta_data->contains($metaData)) {
            $this->meta_data->add($metaData);
        }

        return $this;
    }

    public function removeMetaData(MetaData $metaData): self
    {
        $this->meta_data->removeElement($metaData);

        return $this;
    }

    public function getOrderLine(): ?Order
    {
        return $this->order_line;
    }

    public function setOrderLine(?Order $order_line): self
    {
        $this->order_line = $order_line;

        return $this;
    }

    public function getCart(): ?Cart
    {
        return $this->cart;
    }

    public function setCart(?Cart $cart): self
    {
        $this->cart = $cart;

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
}
