<?php

namespace App\Catalog\Application\View;

readonly class ProductView
{
    public string $sku;
    public string $name;
    public string $description;
    public string $categoryName;
    public int $price;
    public string $currency;

    /**
     * @param string $sku
     * @param string $name
     * @param string $description
     * @param string $categoryName
     * @param int $price
     * @param string $currency
     */
    public function __construct(string $sku, string $name, string $description, string $categoryName, int $price, string $currency)
    {
        $this->sku = $sku;
        $this->name = $name;
        $this->description = $description;
        $this->categoryName = $categoryName;
        $this->price = $price;
        $this->currency = $currency;
    }
}
