<?php

namespace App\Tests\Catalog\Domain\Model\Product;

use App\Catalog\Domain\Model\Category\CategoryId;
use App\Catalog\Domain\Model\Product\InvalidDescriptionException;
use App\Catalog\Domain\Model\Product\InvalidNameException;
use App\Catalog\Domain\Model\Product\InvalidPriceException;
use App\Catalog\Domain\Model\Product\Product;
use App\Catalog\Domain\Model\Product\ProductId;
use App\Shared\Domain\Model\Currency;
use App\Shared\Domain\Model\Money;
use App\Shared\Domain\Model\SKU;
use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{

    private function validProduct(?Money $price = null): Product
    {
        return Product::create(
            ProductId::create(),
            SKU::create("sample-sku"),
            'valid name',
            'valid description',
            $price ?? Money::create(100, Currency::create("EUR")),
            CategoryId::create(),
        );
    }
    public function testProductCanNotHaveNameShorterThanFourCharacters()
    {
        $this->expectException(InvalidNameException::class);

        Product::create(
            ProductId::create(),
            SKU::create("sample-sku"),
            'abc',
            'Some description',
            Money::create(
                100,
                Currency::create("EUR")
            ),
            CategoryId::create(),
        );
    }

    public function testProductCanNotHaveDescriptionShorterThanFourCharacters()
    {
        $this->expectException(InvalidDescriptionException::class);

        Product::create(
            ProductId::create(),
            SKU::create("sample-sku"),
            'cool name',
            'abc',
            Money::create(
                100,
                Currency::create("EUR")
            ),
            CategoryId::create(),
        );
    }

    public function testFourCharactersNameIsAllowed()
    {
        $product = Product::create(
            ProductId::create(),
            SKU::create("sample-sku"),
            'name',
            'cool description',
            Money::create(
                0,
                Currency::create("EUR")
            ),
            CategoryId::create(),
        );

        $this->assertSame('name', $product->name());
    }

    public function testFourCharactersDescriptionIsAllowed()
    {
        $product = Product::create(
            ProductId::create(),
            SKU::create("sample-sku"),
            'cool name',
            'desc',
            Money::create(
                0,
                Currency::create("EUR")
            ),
            CategoryId::create(),
        );

        $this->assertSame('desc', $product->description());
    }

    public function testCanNotPublishWithPriceAmountZero()
    {
        $this->expectException(InvalidPriceException::class);

        $product = $this->validProduct(
            Money::create(
                0,
                Currency::create("EUR")
            ),
        );

        $product->publish();
    }

    public function testCanPublishWithValidPrice()
    {
        $product = $this->validProduct();

        $product->publish();

        $this->assertTrue($product->published());
    }

    public function testRenameProductWithValidName()
    {
        $product = $this->validProduct();

        $product->renameTo('new name');
        $this->assertSame('new name', $product->name());
    }
}
