<?php

namespace App\Tests\Catalog\Application\Service\Product;

use App\Catalog\Application\Service\Product\PublishProductCommand;
use App\Catalog\Application\Service\Product\PublishProductHandler;
use App\Catalog\Domain\Model\Category\CategoryId;
use App\Catalog\Domain\Model\Product\InvalidPriceException;
use App\Catalog\Domain\Model\Product\Product;
use App\Catalog\Domain\Model\Product\ProductDoesNotExistException;
use App\Catalog\Domain\Model\Product\ProductId;
use App\Catalog\Domain\Model\Product\ProductRepository;
use App\Catalog\Infrastructure\Persistence\InMemory\Product\InMemoryProductRepository;
use App\Shared\Domain\Model\Currency;
use App\Shared\Domain\Model\Money;
use App\Shared\Domain\Model\SKU;
use PHPUnit\Framework\TestCase;

class PublishProductHandlerTest extends TestCase
{
    private ProductRepository $repository;
    private PublishProductHandler $handler;
    protected function setUp(): void
    {
        $this->repository = new InMemoryProductRepository();
        $this->handler = new PublishProductHandler($this->repository);
    }
    public function testProductCanBePublished(): void
    {
        $categoryId = CategoryId::create();
        $product = Product::create(
            ProductId::create(),
            SKU::create('cool-sku'),
            'name',
            'description',
                Money::create(
                    100,
                    Currency::create('EUR')
                ),
            $categoryId,
        );

        $this->repository->add($product);


        $this->handler->handle(new PublishProductCommand('cool-sku'));

        $product = $this->repository->ofSku(SKU::create('cool-sku'));

        $this->assertTrue($product->published());

    }

    public function testProductWithInvalidPriceAmountCanNotBePublished(): void
    {
        $categoryId = CategoryId::create();
        $product = Product::create(
            ProductId::create(),
            SKU::create('cool-sku'),
            'name',
            'description',
            Money::create(
                0,
                Currency::create('EUR')
            ),
            $categoryId,
        );

        $this->repository->add($product);

        $this->expectException(InvalidPriceException::class);

        $this->handler->handle(new PublishProductCommand('cool-sku'));
    }

    public function testCanNotPublishProductThatDoesNotExist(): void
    {
        $this->expectException(ProductDoesNotExistException::class);
        $this->handler->handle(new PublishProductCommand('cool-sku'));
    }
}
