<?php

namespace App\Catalog\Application\View;

readonly class ProductView
{
    private string $sku;
    private string $name;
    private string $description;
    private string $categoryName;
    private int $price;
    private string $currency;

    public function __construct(string $sku, string $name, string $description, string $categoryName, int $price, string $currency)
    {
        $this->sku = $sku;
        $this->name = $name;
        $this->description = $description;
        $this->categoryName = $categoryName;
        $this->price = $price;
        $this->currency = $currency;
    }

    public function getSku(): string
    {
        return $this->sku;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getCategoryName(): string
    {
        return $this->categoryName;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }
}
