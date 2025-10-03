<?php

namespace App\Catalog\Domain;

use App\Shared\Domain\Money;

class Product
{
    private ProductId $id;
    private SKU $sku;
    private string $name;
    private string $description;
    private Money $price;
    private bool $published;
    private CategoryId $categoryId;

    /**
     * @param ProductId $id
     * @param SKU $sku
     * @param string $name
     * @param string $description
     * @param Money $price
     * @param CategoryId $categoryId
     */
    public function __construct(ProductId $id, SKU $sku, string $name, string $description, Money $price, CategoryId $categoryId)
    {
        $this->id = $id;
        $this->sku = $sku;
        $this->setName($name);
        $this->setDescription($description);
        $this->price = $price;
        $this->categoryId = $categoryId;
        $this->published = false;
    }

    private function setName(string $name): void
    {
        $name = trim($name);

        if (strlen($name) < 4) {
            throw new InvalidNameException('Product name is too short, minimum is 4 characters');
        }

        $this->name = $name;
    }

    private function setDescription(string $description): void
    {
        $description = trim($description);

        if (strlen($description) < 4) {
            throw new InvalidDescriptionException('Product description is too short, minimum is 4 characters');
        }

        $this->description = $description;
    }

    public function renameTo(string $name): void
    {
        $this->setName($name);
    }

    public function repriceTo(Money $price): void
    {
        $this->price = $price;
    }

    public function publish() : void
    {
        if ($this->price->amount() === 0) {
            throw new InvalidPriceException("For a Product to be published, the price must be higher than 0");
        }

        $this->published = true;
    }
}
