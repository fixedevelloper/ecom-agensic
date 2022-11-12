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
    use DateTimeTrait;
    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $slug = null;
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $status = null;
    #[ORM\Column(length: 255, nullable: true)]
    private ?bool $featured = false;
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $catalog_visibility = null;
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $short_description = null;
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $sku = null;
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $tax_status = null;
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $tax_class = null;
    #[ORM\Column(length: 255, nullable: true)]
    private ?bool $shipping_required = false;
    #[ORM\Column(length: 255, nullable: true)]
    private ?bool $shipping_taxable = false;
    #[ORM\Column(length: 255, nullable: true)]
    private ?bool $on_sale = false;

    #[ORM\Column(nullable: true)]
    private ?float $price = null;

    #[ORM\Column(nullable: true)]
    private ?float $regular_price = null;

    #[ORM\Column(nullable: true)]
    private ?float $sale_price = null;

    #[ORM\Column]
    private ?int $total_sales = 1;

    #[ORM\Column]
    private ?bool $manage_stock = false;

    #[ORM\Column]
    private ?int $stock_quantity = 0;

    #[ORM\Column]
    private ?bool $in_stock = false;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $weight = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $average_rating = null;

    #[ORM\Column]
    private ?int $rating_count = 0;

    #[ORM\Column]
    private ?int $parent_id = 0;

    #[ORM\ManyToMany(targetEntity: Category::class, inversedBy: 'products')]
    private Collection $categories;

    #[ORM\ManyToMany(targetEntity: Image::class)]
    private Collection $images;

    #[ORM\ManyToMany(targetEntity: Attribute::class)]
    private Collection $attributes;

    #[ORM\Column(nullable: true)]
    private ?int $menu_order = null;

    #[ORM\ManyToMany(targetEntity: MetaData::class)]
    private Collection $meta_data;

    #[ORM\Column(nullable: true)]
    private array $tags = [];

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $type = null;

    #[ORM\Column(nullable: true)]
    private ?float $length = null;

    #[ORM\Column(nullable: true)]
    private ?float $width = null;

    #[ORM\Column(nullable: true)]
    private ?float $height = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    private ?Shop $shop = null;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->images = new ArrayCollection();
        $this->attributes = new ArrayCollection();
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

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * @param string|null $status
     */
    public function setStatus(?string $status): void
    {
        $this->status = $status;
    }

    /**
     * @return bool|null
     */
    public function getFeatured(): ?bool
    {
        return $this->featured;
    }

    /**
     * @param bool|null $featured
     */
    public function setFeatured(?bool $featured): void
    {
        $this->featured = $featured;
    }

    /**
     * @return string|null
     */
    public function getCatalogVisibility(): ?string
    {
        return $this->catalog_visibility;
    }

    /**
     * @param string|null $catalog_visibility
     */
    public function setCatalogVisibility(?string $catalog_visibility): void
    {
        $this->catalog_visibility = $catalog_visibility;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return string|null
     */
    public function getShortDescription(): ?string
    {
        return $this->short_description;
    }

    /**
     * @param string|null $short_description
     */
    public function setShortDescription(?string $short_description): void
    {
        $this->short_description = $short_description;
    }

    /**
     * @return string|null
     */
    public function getSku(): ?string
    {
        return $this->sku;
    }

    /**
     * @param string|null $sku
     */
    public function setSku(?string $sku): void
    {
        $this->sku = $sku;
    }

    /**
     * @return string|null
     */
    public function getTaxStatus(): ?string
    {
        return $this->tax_status;
    }

    /**
     * @param string|null $tax_status
     */
    public function setTaxStatus(?string $tax_status): void
    {
        $this->tax_status = $tax_status;
    }

    /**
     * @return string|null
     */
    public function getTaxClass(): ?string
    {
        return $this->tax_class;
    }

    /**
     * @param string|null $tax_class
     */
    public function setTaxClass(?string $tax_class): void
    {
        $this->tax_class = $tax_class;
    }

    /**
     * @return bool|null
     */
    public function getShippingRequired(): ?bool
    {
        return $this->shipping_required;
    }

    /**
     * @param bool|null $shipping_required
     */
    public function setShippingRequired(?bool $shipping_required): void
    {
        $this->shipping_required = $shipping_required;
    }

    /**
     * @return bool|null
     */
    public function getShippingTaxable(): ?bool
    {
        return $this->shipping_taxable;
    }

    /**
     * @param bool|null $shipping_taxable
     */
    public function setShippingTaxable(?bool $shipping_taxable): void
    {
        $this->shipping_taxable = $shipping_taxable;
    }

    /**
     * @return bool|null
     */
    public function getOnSale(): ?bool
    {
        return $this->on_sale;
    }

    /**
     * @param bool|null $on_sale
     */
    public function setOnSale(?bool $on_sale): void
    {
        $this->on_sale = $on_sale;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): self
    {
        $this->slug = $slug;

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

    public function setRegularPrice(?float $regular_price): self
    {
        $this->regular_price = $regular_price;

        return $this;
    }

    public function getSalePrice(): ?float
    {
        return $this->sale_price;
    }

    public function setSalePrice(?float $sale_price): self
    {
        $this->sale_price = $sale_price;

        return $this;
    }

    public function getTotalSales(): ?int
    {
        return $this->total_sales;
    }

    public function setTotalSales(int $total_sales): self
    {
        $this->total_sales = $total_sales;

        return $this;
    }

    public function isManageStock(): ?bool
    {
        return $this->manage_stock;
    }

    public function setManageStock(bool $manage_stock): self
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

    public function setInStock(bool $in_stock): self
    {
        $this->in_stock = $in_stock;

        return $this;
    }

    public function getWeight(): ?string
    {
        return $this->weight;
    }

    public function setWeight(?string $weight): self
    {
        $this->weight = $weight;

        return $this;
    }

    public function getAverageRating(): ?string
    {
        return $this->average_rating;
    }

    public function setAverageRating(?string $average_rating): self
    {
        $this->average_rating = $average_rating;

        return $this;
    }

    public function getRatingCount(): ?int
    {
        return $this->rating_count;
    }

    public function setRatingCount(int $rating_count): self
    {
        $this->rating_count = $rating_count;

        return $this;
    }

    public function getParentId(): ?int
    {
        return $this->parent_id;
    }

    public function setParentId(int $parent_id): self
    {
        $this->parent_id = $parent_id;

        return $this;
    }

    /**
     * @return Collection<int, Category>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        $this->categories->removeElement($category);

        return $this;
    }

    /**
     * @return Collection<int, Image>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images->add($image);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        $this->images->removeElement($image);

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

    public function getMenuOrder(): ?int
    {
        return $this->menu_order;
    }

    public function setMenuOrder(?int $menu_order): self
    {
        $this->menu_order = $menu_order;

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

    public function getTags(): array
    {
        return $this->tags;
    }

    public function setTags(?array $tags): self
    {
        $this->tags = $tags;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getLength(): ?int
    {
        return $this->length;
    }

    public function setLength(int $length): self
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

    public function getShop(): ?Shop
    {
        return $this->shop;
    }

    public function setShop(?Shop $shop): self
    {
        $this->shop = $shop;

        return $this;
    }
}
