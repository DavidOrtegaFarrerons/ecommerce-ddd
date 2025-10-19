<?php

namespace App\Catalog\Application\Service\Product;

class UpdateProductCommand
{
    private string $sku;
    private ?string $name;
    private ?string $description;
    private ?int $priceAmount;
    private ?string $priceCurrency;
    private ?string $categoryId;

    public function __construct(string $sku, ?string $name = null, ?string $description = null, ?int $priceAmount = null, ?string $priceCurrency = null, ?string $categoryId = null)
    {
        $this->sku = $sku;
        $this->name = $name;
        $this->description = $description;
        $this->priceAmount = $priceAmount;
        $this->priceCurrency = $priceCurrency;
        $this->categoryId = $categoryId;
    }

    public function getSku(): string
    {
        return $this->sku;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getPriceAmount(): ?int
    {
        return $this->priceAmount;
    }

    public function getPriceCurrency(): ?string
    {
        return $this->priceCurrency;
    }

    public function getCategoryId(): ?string
    {
        return $this->categoryId;
    }
}
