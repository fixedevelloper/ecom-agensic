<?php


namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
trait InformationTrait
{
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $first_name = null;
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $last_name = null;
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $company = null;
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $address_1 = null;
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $address_2 = null;
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $city = null;
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $state = null;
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $postcode = null;
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $country = null;
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $email = null;

    /**
     * @return string|null
     */
    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    /**
     * @param string|null $first_name
     */
    public function setFirstName(?string $first_name): void
    {
        $this->first_name = $first_name;
    }

    /**
     * @return string|null
     */
    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    /**
     * @param string|null $last_name
     */
    public function setLastName(?string $last_name): void
    {
        $this->last_name = $last_name;
    }

    /**
     * @return string|null
     */
    public function getCompany(): ?string
    {
        return $this->company;
    }

    /**
     * @param string|null $company
     */
    public function setCompany(?string $company): void
    {
        $this->company = $company;
    }

    /**
     * @return string|null
     */
    public function getAddress1(): ?string
    {
        return $this->address_1;
    }

    /**
     * @param string|null $address_1
     */
    public function setAddress1(?string $address_1): void
    {
        $this->address_1 = $address_1;
    }

    /**
     * @return string|null
     */
    public function getAddress2(): ?string
    {
        return $this->address_2;
    }

    /**
     * @param string|null $address_2
     */
    public function setAddress2(?string $address_2): void
    {
        $this->address_2 = $address_2;
    }

    /**
     * @return string|null
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * @param string|null $city
     */
    public function setCity(?string $city): void
    {
        $this->city = $city;
    }

    /**
     * @return string|null
     */
    public function getState(): ?string
    {
        return $this->state;
    }

    /**
     * @param string|null $state
     */
    public function setState(?string $state): void
    {
        $this->state = $state;
    }

    /**
     * @return string|null
     */
    public function getPostcode(): ?string
    {
        return $this->postcode;
    }

    /**
     * @param string|null $postcode
     */
    public function setPostcode(?string $postcode): void
    {
        $this->postcode = $postcode;
    }

    /**
     * @return string|null
     */
    public function getCountry(): ?string
    {
        return $this->country;
    }

    /**
     * @param string|null $country
     */
    public function setCountry(?string $country): void
    {
        $this->country = $country;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     */
    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

}
