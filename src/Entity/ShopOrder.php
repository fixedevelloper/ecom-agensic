<?php

namespace App\Entity;

use App\Repository\ShopOrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ShopOrderRepository::class)]
class ShopOrder
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    use DateTimeTrait;
    #[ORM\ManyToOne(inversedBy: 'shopOrders')]
    private ?Shop $shop = null;

    #[ORM\OneToMany(mappedBy: 'shopOrder', targetEntity: ShopOrderLine::class)]
    private Collection $shoporderliine;

    #[ORM\ManyToOne(inversedBy: 'shopOrders')]
    private ?Order $parentOrder = null;
    #[ORM\Column]
    private ?float $total = null;

    #[ORM\Column]
    private ?float $total_tax = null;

    #[ORM\Column(nullable: true)]
    private ?bool $prices_include_tax = null;
    #[ORM\Column(nullable: true)]
    private ?float $discount_total = null;

    #[ORM\Column(nullable: true)]
    private ?float $discount_tax = null;
    #[ORM\Column(length: 255)]
    private ?string $status = null;
    public function __construct()
    {
        $this->shoporderliine = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return float|null
     */
    public function getTotal(): ?float
    {
        return $this->total;
    }

    /**
     * @param float|null $total
     */
    public function setTotal(?float $total): void
    {
        $this->total = $total;
    }

    /**
     * @return float|null
     */
    public function getTotalTax(): ?float
    {
        return $this->total_tax;
    }

    /**
     * @param float|null $total_tax
     */
    public function setTotalTax(?float $total_tax): void
    {
        $this->total_tax = $total_tax;
    }

    /**
     * @return bool|null
     */
    public function getPricesIncludeTax(): ?bool
    {
        return $this->prices_include_tax;
    }

    /**
     * @param bool|null $prices_include_tax
     */
    public function setPricesIncludeTax(?bool $prices_include_tax): void
    {
        $this->prices_include_tax = $prices_include_tax;
    }

    /**
     * @return float|null
     */
    public function getDiscountTotal(): ?float
    {
        return $this->discount_total;
    }

    /**
     * @param float|null $discount_total
     */
    public function setDiscountTotal(?float $discount_total): void
    {
        $this->discount_total = $discount_total;
    }

    /**
     * @return float|null
     */
    public function getDiscountTax(): ?float
    {
        return $this->discount_tax;
    }

    /**
     * @param float|null $discount_tax
     */
    public function setDiscountTax(?float $discount_tax): void
    {
        $this->discount_tax = $discount_tax;
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
     * @return Collection<int, ShopOrderLine>
     */
    public function getShoporderliine(): Collection
    {
        return $this->shoporderliine;
    }

    public function addShoporderliine(ShopOrderLine $shoporderliine): self
    {
        if (!$this->shoporderliine->contains($shoporderliine)) {
            $this->shoporderliine->add($shoporderliine);
            $shoporderliine->setShopOrder($this);
        }

        return $this;
    }

    public function removeShoporderliine(ShopOrderLine $shoporderliine): self
    {
        if ($this->shoporderliine->removeElement($shoporderliine)) {
            // set the owning side to null (unless already changed)
            if ($shoporderliine->getShopOrder() === $this) {
                $shoporderliine->setShopOrder(null);
            }
        }

        return $this;
    }

    public function getParentOrder(): ?Order
    {
        return $this->parentOrder;
    }

    public function setParentOrder(?Order $parentOrder): self
    {
        $this->parentOrder = $parentOrder;

        return $this;
    }
}
