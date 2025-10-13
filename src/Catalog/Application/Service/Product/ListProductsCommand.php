<?php

namespace App\Catalog\Application\Service\Product;

class ListProductsCommand
{
    private ?string $sku;
    private ?string $name;
    private ?int $price;
    private ?string $categoryName;

    /**
     * @param string|null $sku
     * @param string|null $name
     * @param int|null $price
     * @param string|null $categoryName
     */
    public function __construct(?string $sku = null, ?string $name = null, ?int $price = null, ?string $categoryName = null)
    {
        $this->sku = $sku;
        $this->name = $name;
        $this->price = $price;
        $this->categoryName = $categoryName;
    }

    public function getSku(): ?string
    {
        return $this->sku;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function getCategoryName(): ?string
    {
        return $this->categoryName;
    }
}
