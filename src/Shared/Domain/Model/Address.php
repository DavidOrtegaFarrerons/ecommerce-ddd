<?php

namespace App\Shared\Domain\Model;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
class Address
{
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $street;

    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    private ?string $city;

    #[ORM\Column(type: 'string', length: 20, nullable: true)]
    private ?string $postalCode;

    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    private ?string $country;

    public function __construct(
        string $street,
        string $city,
        string $postalCode,
        string $country,
    ) {
        $this->street = $street;
        $this->city = $city;
        $this->postalCode = $postalCode;
        $this->country = $country;
    }

    public static function create(string $street, string $city, string $postalCode, string $country): Address
    {
        return new self($street, $city, $postalCode, $country);
    }

    public function street(): string
    {
        return $this->street;
    }

    public function city(): string
    {
        return $this->city;
    }

    public function postalCode(): string
    {
        return $this->postalCode;
    }

    public function country(): string
    {
        return $this->country;
    }
}
