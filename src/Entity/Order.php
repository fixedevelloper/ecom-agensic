<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    use DateTimeTrait;
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $number = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $order_key = null;

    #[ORM\Column(length: 255)]
    private ?string $status = null;

    #[ORM\Column(length: 255)]
    private ?string $currency = null;

    #[ORM\Column(nullable: true)]
    private ?float $discount_total = null;

    #[ORM\Column(nullable: true)]
    private ?float $discount_tax = null;

    #[ORM\Column(nullable: true)]
    private ?float $shipping_total = null;

    #[ORM\Column(nullable: true)]
    private ?float $shipping_tax = null;

    #[ORM\Column(nullable: true)]
    private ?float $cart_tax = null;

    #[ORM\Column]
    private ?float $total = null;

    #[ORM\Column]
    private ?float $total_tax = null;

    #[ORM\Column(nullable: true)]
    private ?bool $prices_include_tax = null;

    #[ORM\Column]
    private ?int $customer_id = null;

    #[ORM\Column(length: 255)]
    private ?string $customer_ip_address = null;

    #[ORM\Column(length: 255)]
    private ?string $customer_note = null;

    #[ORM\ManyToOne]
    private ?Billing $billing = null;

    #[ORM\ManyToOne]
    private ?Shipping $shipping = null;

    #[ORM\Column(length: 255)]
    private ?string $payment_method = null;

    #[ORM\Column(length: 255)]
    private ?string $payment_method_title = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_paid = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_completed = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $cart_hash = null;

    #[ORM\OneToMany(mappedBy: 'order_line', targetEntity: LineItem::class)]
    private Collection $line_items;

    #[ORM\OneToMany(mappedBy: 'order_shipping', targetEntity: ShippingLine::class)]
    private Collection $shipping_lines;

    #[ORM\Column(nullable: true)]
    private array $fee_lines = [];

    #[ORM\Column(nullable: true)]
    private array $coupon_lines = [];

    #[ORM\Column(nullable: true)]
    private array $refunds = [];

    public function __construct()
    {
        $this->line_items = new ArrayCollection();
        $this->shipping_lines = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function setNumber(?string $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function getOrderKey(): ?string
    {
        return $this->order_key;
    }

    public function setOrderKey(?string $order_key): self
    {
        $this->order_key = $order_key;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    public function setCurrency(string $currency): self
    {
        $this->currency = $currency;

        return $this;
    }

    public function getDiscountTotal(): ?float
    {
        return $this->discount_total;
    }

    public function setDiscountTotal(?float $discount_total): self
    {
        $this->discount_total = $discount_total;

        return $this;
    }

    public function getDiscountTax(): ?float
    {
        return $this->discount_tax;
    }

    public function setDiscountTax(?float $discount_tax): self
    {
        $this->discount_tax = $discount_tax;

        return $this;
    }

    public function getShippingTotal(): ?float
    {
        return $this->shipping_total;
    }

    public function setShippingTotal(?float $shipping_total): self
    {
        $this->shipping_total = $shipping_total;

        return $this;
    }

    public function getShippingTax(): ?float
    {
        return $this->shipping_tax;
    }

    public function setShippingTax(?float $shipping_tax): self
    {
        $this->shipping_tax = $shipping_tax;

        return $this;
    }

    public function getCartTax(): ?float
    {
        return $this->cart_tax;
    }

    public function setCartTax(?float $cart_tax): self
    {
        $this->cart_tax = $cart_tax;

        return $this;
    }

    public function getTotal(): ?float
    {
        return $this->total;
    }

    public function setTotal(float $total): self
    {
        $this->total = $total;

        return $this;
    }

    public function getTotalTax(): ?float
    {
        return $this->total_tax;
    }

    public function setTotalTax(float $total_tax): self
    {
        $this->total_tax = $total_tax;

        return $this;
    }

    public function isPricesIncludeTax(): ?bool
    {
        return $this->prices_include_tax;
    }

    public function setPricesIncludeTax(?bool $prices_include_tax): self
    {
        $this->prices_include_tax = $prices_include_tax;

        return $this;
    }

    public function getCustomerId(): ?int
    {
        return $this->customer_id;
    }

    public function setCustomerId(int $customer_id): self
    {
        $this->customer_id = $customer_id;

        return $this;
    }

    public function getCustomerIpAddress(): ?string
    {
        return $this->customer_ip_address;
    }

    public function setCustomerIpAddress(string $customer_ip_address): self
    {
        $this->customer_ip_address = $customer_ip_address;

        return $this;
    }

    public function getCustomerNote(): ?string
    {
        return $this->customer_note;
    }

    public function setCustomerNote(string $customer_note): self
    {
        $this->customer_note = $customer_note;

        return $this;
    }

    public function getBilling(): ?Billing
    {
        return $this->billing;
    }

    public function setBilling(?Billing $billing): self
    {
        $this->billing = $billing;

        return $this;
    }

    public function getShipping(): ?Shipping
    {
        return $this->shipping;
    }

    public function setShipping(?Shipping $shipping): self
    {
        $this->shipping = $shipping;

        return $this;
    }

    public function getPaymentMethod(): ?string
    {
        return $this->payment_method;
    }

    public function setPaymentMethod(string $payment_method): self
    {
        $this->payment_method = $payment_method;

        return $this;
    }

    public function getPaymentMethodTitle(): ?string
    {
        return $this->payment_method_title;
    }

    public function setPaymentMethodTitle(string $payment_method_title): self
    {
        $this->payment_method_title = $payment_method_title;

        return $this;
    }

    public function getDatePaid(): ?\DateTimeInterface
    {
        return $this->date_paid;
    }

    public function setDatePaid(?\DateTimeInterface $date_paid): self
    {
        $this->date_paid = $date_paid;

        return $this;
    }

    public function getDateCompleted(): ?\DateTimeInterface
    {
        return $this->date_completed;
    }

    public function setDateCompleted(?\DateTimeInterface $date_completed): self
    {
        $this->date_completed = $date_completed;

        return $this;
    }

    public function getCartHash(): ?string
    {
        return $this->cart_hash;
    }

    public function setCartHash(?string $cart_hash): self
    {
        $this->cart_hash = $cart_hash;

        return $this;
    }

    /**
     * @return Collection<int, LineItem>
     */
    public function getLineItems(): Collection
    {
        return $this->line_items;
    }

    public function addLineItem(LineItem $lineItem): self
    {
        if (!$this->line_items->contains($lineItem)) {
            $this->line_items->add($lineItem);
            $lineItem->setOrderLine($this);
        }

        return $this;
    }

    public function removeLineItem(LineItem $lineItem): self
    {
        if ($this->line_items->removeElement($lineItem)) {
            // set the owning side to null (unless already changed)
            if ($lineItem->getOrderLine() === $this) {
                $lineItem->setOrderLine(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ShippingLine>
     */
    public function getShippingLines(): Collection
    {
        return $this->shipping_lines;
    }

    public function addShippingLine(ShippingLine $shippingLine): self
    {
        if (!$this->shipping_lines->contains($shippingLine)) {
            $this->shipping_lines->add($shippingLine);
            $shippingLine->setOrderShipping($this);
        }

        return $this;
    }

    public function removeShippingLine(ShippingLine $shippingLine): self
    {
        if ($this->shipping_lines->removeElement($shippingLine)) {
            // set the owning side to null (unless already changed)
            if ($shippingLine->getOrderShipping() === $this) {
                $shippingLine->setOrderShipping(null);
            }
        }

        return $this;
    }

    public function getFeeLines(): array
    {
        return $this->fee_lines;
    }

    public function setFeeLines(?array $fee_lines): self
    {
        $this->fee_lines = $fee_lines;

        return $this;
    }

    public function getCouponLines(): array
    {
        return $this->coupon_lines;
    }

    public function setCouponLines(?array $coupon_lines): self
    {
        $this->coupon_lines = $coupon_lines;

        return $this;
    }

    public function getRefunds(): array
    {
        return $this->refunds;
    }

    public function setRefunds(?array $refunds): self
    {
        $this->refunds = $refunds;

        return $this;
    }
}
