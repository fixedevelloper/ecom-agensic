<?php

namespace App\Entity;

use App\Repository\ShopOrderLineRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ShopOrderLineRepository::class)]
class ShopOrderLine
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'shoporderliine')]
    private ?ShopOrder $shopOrder = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?LineItem $lineorder = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getShopOrder(): ?ShopOrder
    {
        return $this->shopOrder;
    }

    public function setShopOrder(?ShopOrder $shopOrder): self
    {
        $this->shopOrder = $shopOrder;

        return $this;
    }

    public function getLineorder(): ?LineItem
    {
        return $this->lineorder;
    }

    public function setLineorder(?LineItem $lineorder): self
    {
        $this->lineorder = $lineorder;

        return $this;
    }
}
