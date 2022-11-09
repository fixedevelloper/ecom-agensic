<?php

namespace App\Entity;
use App\Repository\CartRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CartRepository::class)]
class Cart
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    #[ORM\Column(length: 255, nullable: true)]
   private string $payment_method="";
    #[ORM\Column(length: 255, nullable: true)]
   private string $payment_method_title;
    #[ORM\ManyToOne]
   private Billing $billing;
    #[ORM\ManyToOne]
   private Shipping $shipping;
    #[ORM\Column(nullable: true)]
    private int $customer_id;
    private array $meta_data_=[];
    #[ORM\Column(nullable: true)]
    private bool $set_paid=false;

    #[ORM\OneToMany(mappedBy: 'cart', targetEntity: LineItem::class)]
    private Collection $line_items;

    #[ORM\OneToMany(mappedBy: 'cart', targetEntity: ShippingLine::class)]
    private Collection $line_shippings;

    public function __construct()
    {
        $this->line_items = new ArrayCollection();
        $this->line_shippings = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getPaymentMethod(): string
    {
        return $this->payment_method;
    }

    /**
     * @param string $payment_method
     */
    public function setPaymentMethod(string $payment_method): void
    {
        $this->payment_method = $payment_method;
    }

    /**
     * @return string
     */
    public function getPaymentMethodTitle(): string
    {
        return $this->payment_method_title;
    }

    /**
     * @param string $payment_method_title
     */
    public function setPaymentMethodTitle(string $payment_method_title): void
    {
        $this->payment_method_title = $payment_method_title;
    }

    /**
     * @return Billing
     */
    public function getBilling(): Billing
    {
        return $this->billing;
    }

    /**
     * @param Billing $billing
     */
    public function setBilling(Billing $billing): void
    {
        $this->billing = $billing;
    }

    /**
     * @return Shipping
     */
    public function getShipping(): Shipping
    {
        return $this->shipping;
    }

    /**
     * @param Shipping $shipping
     */
    public function setShipping(Shipping $shipping): void
    {
        $this->shipping = $shipping;
    }

    /**
     * @param int $customer_id
     */
    public function setCustomerId(int $customer_id): void
    {
        $this->customer_id = $customer_id;
    }
    /**
     * @return bool
     */
    public function isSetPaid(): bool
    {
        return $this->set_paid;
    }

    /**
     * @param bool $set_paid
     */
    public function setSetPaid(bool $set_paid): void
    {
        $this->set_paid = $set_paid;
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
            $lineItem->setCart($this);
        }

        return $this;
    }

    public function removeLineItem(LineItem $lineItem): self
    {
        if ($this->line_items->removeElement($lineItem)) {
            // set the owning side to null (unless already changed)
            if ($lineItem->getCart() === $this) {
                $lineItem->setCart(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ShippingLine>
     */
    public function getLineShippings(): Collection
    {
        return $this->line_shippings;
    }

    public function addLineShipping(ShippingLine $lineShipping): self
    {
        if (!$this->line_shippings->contains($lineShipping)) {
            $this->line_shippings->add($lineShipping);
            $lineShipping->setCart($this);
        }

        return $this;
    }

    public function removeLineShipping(ShippingLine $lineShipping): self
    {
        if ($this->line_shippings->removeElement($lineShipping)) {
            // set the owning side to null (unless already changed)
            if ($lineShipping->getCart() === $this) {
                $lineShipping->setCart(null);
            }
        }

        return $this;
    }
}
