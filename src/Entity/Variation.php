<?php

namespace App\Entity;

use App\Repository\VariationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VariationRepository::class)]
class Variation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $sku = null;

    #[ORM\Column]
    private ?float $price = null;

    #[ORM\Column]
    private ?float $regular_price = null;

    #[ORM\Column]
    private ?float $sale_price = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_on_sale_from = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_on_sale_to = null;

    #[ORM\Column(nullable: true)]
    private ?bool $on_sale = null;

    #[ORM\Column(nullable: true)]
    private ?bool $visible = null;

    #[ORM\Column(nullable: true)]
    private ?bool $purchasable = null;

    #[ORM\Column(length: 255)]
    private ?string $tax_status = null;

    #[ORM\Column(length: 255)]
    private ?string $tax_class = null;

    #[ORM\Column(nullable: true)]
    private ?bool $manage_stock = null;

    #[ORM\Column]
    private ?int $stock_quantity = null;

    #[ORM\Column(nullable: true)]
    private ?bool $in_stock = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $shipping_class = null;

    #[ORM\Column(nullable: true)]
    private ?int $shipping_class_id = null;

    #[ORM\ManyToOne]
    private ?Image $image = null;

    #[ORM\ManyToMany(targetEntity: Attribute::class, inversedBy: 'variations')]
    private Collection $attributes;

    #[ORM\ManyToMany(targetEntity: MetaData::class)]
    private Collection $meta_data;

    #[ORM\Column(nullable: true)]
    private ?int $length = null;

    #[ORM\Column(nullable: true)]
    private ?float $width = null;

    #[ORM\Column(nullable: true)]
    private ?float $height = null;

    public function __construct()
    {
        $this->attributes = new ArrayCollection();
        $this->meta_data = new ArrayCollection();
    }
    use DateTimeTrait;
    public function getId(): ?int
    {
        return $this->id;
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

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getRegularPrice(): ?float
    {
        return $this->regular_price;
    }

    public function setRegularPrice(float $regular_price): self
    {
        $this->regular_price = $regular_price;

        return $this;
    }

    public function getSalePrice(): ?float
    {
        return $this->sale_price;
    }

    public function setSalePrice(float $sale_price): self
    {
        $this->sale_price = $sale_price;

        return $this;
    }

    public function getDateOnSaleFrom(): ?\DateTimeInterface
    {
        return $this->date_on_sale_from;
    }

    public function setDateOnSaleFrom(?\DateTimeInterface $date_on_sale_from): self
    {
        $this->date_on_sale_from = $date_on_sale_from;

        return $this;
    }

    public function getDateOnSaleTo(): ?\DateTimeInterface
    {
        return $this->date_on_sale_to;
    }

    public function setDateOnSaleTo(?\DateTimeInterface $date_on_sale_to): self
    {
        $this->date_on_sale_to = $date_on_sale_to;

        return $this;
    }

    public function isOnSale(): ?bool
    {
        return $this->on_sale;
    }

    public function setOnSale(?bool $on_sale): self
    {
        $this->on_sale = $on_sale;

        return $this;
    }

    public function isVisible(): ?bool
    {
        return $this->visible;
    }

    public function setVisible(?bool $visible): self
    {
        $this->visible = $visible;

        return $this;
    }

    public function isPurchasable(): ?bool
    {
        return $this->purchasable;
    }

    public function setPurchasable(?bool $purchasable): self
    {
        $this->purchasable = $purchasable;

        return $this;
    }

    public function getTaxStatus(): ?string
    {
        return $this->tax_status;
    }

    public function setTaxStatus(string $tax_status): self
    {
        $this->tax_status = $tax_status;

        return $this;
    }

    public function getTaxClass(): ?string
    {
        return $this->tax_class;
    }

    public function setTaxClass(string $tax_class): self
    {
        $this->tax_class = $tax_class;

        return $this;
    }

    public function isManageStock(): ?bool
    {
        return $this->manage_stock;
    }

    public function setManageStock(?bool $manage_stock): self
    {
        $this->manage_stock = $manage_stock;

        return $this;
    }

    public function getStockQuantity(): ?int
    {
        return $this->stock_quantity;
    }

    public function setStockQuantity(int $stock_quantity): self
    {
        $this->stock_quantity = $stock_quantity;

        return $this;
    }

    public function isInStock(): ?bool
    {
        return $this->in_stock;
    }

    public function setInStock(?bool $in_stock): self
    {
        $this->in_stock = $in_stock;

        return $this;
    }

    public function getShippingClass(): ?string
    {
        return $this->shipping_class;
    }

    public function setShippingClass(?string $shipping_class): self
    {
        $this->shipping_class = $shipping_class;

        return $this;
    }

    public function getShippingClassId(): ?int
    {
        return $this->shipping_class_id;
    }

    public function setShippingClassId(?int $shipping_class_id): self
    {
        $this->shipping_class_id = $shipping_class_id;

        return $this;
    }

    public function getImage(): ?Image
    {
        return $this->image;
    }

    public function setImage(?Image $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection<int, Attribute>
     */
    public function getAttributes(): Collection
    {
        return $this->attributes;
    }

    public function addAttribute(Attribute $attribute): self
    {
        if (!$this->attributes->contains($attribute)) {
            $this->attributes->add($attribute);
        }

        return $this;
    }

    public function removeAttribute(Attribute $attribute): self
    {
        $this->attributes->removeElement($attribute);

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

    public function getLength(): ?int
    {
        return $this->length;
    }

    public function setLength(?int $length): self
    {
        $this->length = $length;

        return $this;
    }

    public function getWidth(): ?float
    {
        return $this->width;
    }

    public function setWidth(?float $width): self
    {
        $this->width = $width;

        return $this;
    }

    public function getHeight(): ?float
    {
        return $this->height;
    }

    public function setHeight(?float $height): self
    {
        $this->height = $height;

        return $this;
    }
}
