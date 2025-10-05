<?php

namespace App\Catalog\Domain\Model\Product;

use App\Catalog\Domain\Model\Category\CategoryId;
use App\Shared\Domain\Money;

class Product
{
    private ProductId $id;
    private SKU $sku;
    private string $name;
    private string $description;
    private Money $price;

    private CategoryId $categoryId;
    private bool $published;

    /**
     * @param ProductId $id
     * @param SKU $sku
     * @param string $name
     * @param string $description
     * @param Money $price
     * @param CategoryId $categoryId
     * @param bool $published
     */
    public function __construct(ProductId $id, SKU $sku, string $name, string $description, Money $price, CategoryId $categoryId, bool $published = false)
    {
        $this->id = $id;
        $this->sku = $sku;
        $this->setName($name);
        $this->setDescription($description);
        $this->price = $price;
        $this->categoryId = $categoryId;
        $this->published = $published;
    }

    private function setName(string $name): void
    {
        $name = trim($name);

        if (strlen($name) < 4) {
            throw new InvalidNameException('ProductRecord name is too short, minimum is 4 characters');
        }

        $this->name = $name;
    }

    private function setDescription(string $description): void
    {
        $description = trim($description);

        if (strlen($description) < 4) {
            throw new InvalidDescriptionException('ProductRecord description is too short, minimum is 4 characters');
        }

        $this->description = $description;
    }

    public function renameTo(string $name): void
    {
        $this->setName($name);
    }

    public function changeDescriptionTo(string $description): void
    {
        $this->setDescription($description);
    }

    public function repriceTo(Money $price): void
    {
        $this->price = $price;
    }

    public function changeCategoryTo(CategoryId $categoryId): void
    {
        $this->categoryId = $categoryId;
    }

    public function publish() : void
    {
        if ($this->price->amount() === 0) {
            throw new InvalidPriceException("For a ProductRecord to be published, the price must be higher than 0");
        }

        $this->published = true;
    }

    public function id(): ProductId
    {
        return $this->id;
    }

    public function sku(): SKU
    {
        return $this->sku;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function description(): string
    {
        return $this->description;
    }

    public function price(): Money
    {
        return $this->price;
    }

    public function categoryId(): CategoryId
    {
        return $this->categoryId;
    }

    public function published(): bool
    {
        return $this->published;
    }
}
