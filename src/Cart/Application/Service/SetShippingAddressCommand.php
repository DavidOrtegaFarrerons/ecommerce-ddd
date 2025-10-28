<?php

namespace App\Cart\Application\Service;

class SetShippingAddressCommand
{
    private string $userId;
    private string $street;
    private string $city;
    private string $postalCode;
    private string $country;

    /**
     * @param string $userId
     * @param string $street
     * @param string $city
     * @param string $postalCode
     * @param string $country
     */
    public function __construct(string $userId, string $street, string $city, string $postalCode, string $country)
    {
        $this->userId = $userId;
        $this->street = $street;
        $this->city = $city;
        $this->postalCode = $postalCode;
        $this->country = $country;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function getStreet(): string
    {
        return $this->street;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getPostalCode(): string
    {
        return $this->postalCode;
    }

    public function getCountry(): string
    {
        return $this->country;
    }
}
