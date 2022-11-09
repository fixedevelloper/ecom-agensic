<?php

namespace App\Entity;

use App\Repository\ShippingLineRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ShippingLineRepository::class)]
class ShippingLine
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $method_title = null;

    #[ORM\Column(nullable: true)]
    private ?int $method_id = null;

    #[ORM\Column(nullable: true)]
    private ?int $instance_id = null;

    #[ORM\Column(nullable: true)]
    private ?float $total = null;

    #[ORM\Column(nullable: true)]
    private ?float $total_tax = null;

    #[ORM\Column(nullable: true)]
    private array $taxes = [];

    #[ORM\Column(nullable: true)]
    private array $meta_data = [];

    #[ORM\ManyToOne(inversedBy: 'shipping_lines')]
    private ?Order $order_shipping = null;

    #[ORM\ManyToOne(inversedBy: 'line_shippings')]
    private ?Cart $cart = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMethodTitle(): ?string
    {
        return $this->method_title;
    }

    public function setMethodTitle(?string $method_title): self
    {
        $this->method_title = $method_title;

        return $this;
    }

    public function getMethodId(): ?int
    {
        return $this->method_id;
    }

    public function setMethodId(?int $method_id): self
    {
        $this->method_id = $method_id;

        return $this;
    }

    public function getInstanceId(): ?int
    {
        return $this->instance_id;
    }

    public function setInstanceId(?int $instance_id): self
    {
        $this->instance_id = $instance_id;

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

    public function getTaxes(): array
    {
        return $this->taxes;
    }

    public function setTaxes(?array $taxes): self
    {
        $this->taxes = $taxes;

        return $this;
    }

    public function getMetaData(): array
    {
        return $this->meta_data;
    }

    public function setMetaData(?array $meta_data): self
    {
        $this->meta_data = $meta_data;

        return $this;
    }

    public function getOrderShipping(): ?Order
    {
        return $this->order_shipping;
    }

    public function setOrderShipping(?Order $order_shipping): self
    {
        $this->order_shipping = $order_shipping;

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
}
