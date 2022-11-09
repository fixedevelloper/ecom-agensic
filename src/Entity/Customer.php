<?php

namespace App\Entity;

use App\Repository\CustomerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CustomerRepository::class)]
class Customer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?bool $is_paying_customer = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Billing $billing = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Shipping $shipping = null;

    #[ORM\ManyToMany(targetEntity: MetaData::class)]
    private Collection $meta_data;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?User $compte = null;

    public function __construct()
    {
        $this->meta_data = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isIsPayingCustomer(): ?bool
    {
        return $this->is_paying_customer;
    }

    public function setIsPayingCustomer(?bool $is_paying_customer): self
    {
        $this->is_paying_customer = $is_paying_customer;

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

    public function getCompte(): ?User
    {
        return $this->compte;
    }

    public function setCompte(?User $compte): self
    {
        $this->compte = $compte;

        return $this;
    }
}
