<?php

namespace App\Tests\Catalog\Application\Service\Product;

use App\Catalog\Application\Service\Product\UnpublishProductCommand;
use App\Catalog\Application\Service\Product\UnpublishProductHandler;
use App\Catalog\Domain\Model\Category\CategoryId;
use App\Catalog\Domain\Model\Product\Product;
use App\Catalog\Domain\Model\Product\ProductDoesNotExistException;
use App\Catalog\Domain\Model\Product\ProductId;
use App\Catalog\Domain\Model\Product\ProductRepository;
use App\Catalog\Infrastructure\Persistence\InMemory\Product\InMemoryProductRepository;
use App\Shared\Domain\Model\Currency;
use App\Shared\Domain\Model\Money;
use App\Shared\Domain\Model\SKU;
use PHPUnit\Framework\TestCase;

class UnpublishProductHandlerTest extends TestCase
{
    private ProductRepository $repository;
    private UnpublishProductHandler $handler;

    protected function setUp(): void
    {
        $this->repository = new InMemoryProductRepository();
        $this->handler = new UnpublishProductHandler($this->repository);
    }

    public function testProductCanBeUnpublished(): void
    {
        $categoryId = CategoryId::create();
        $product = new Product(
            ProductId::create(),
            SKU::create('cool-sku'),
            'name',
            'description',
            Money::create(
                100,
                Currency::create('EUR')
            ),
            $categoryId,
            true
        );

        $this->repository->add($product);

        $this->handler->handle(new UnpublishProductCommand('cool-sku'));

        $product = $this->repository->ofSku(SKU::create('cool-sku'));

        $this->assertFalse($product->published());
    }

    public function testUnpublishedProductStaysUnpublished(): void
    {
        $categoryId = CategoryId::create();
        $product = new Product(
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

        $product = $this->repository->ofSku(SKU::create('cool-sku'));
        $this->assertFalse($product->published());

        $this->handler->handle(new UnpublishProductCommand('cool-sku'));

        $product = $this->repository->ofSku(SKU::create('cool-sku'));
        $this->assertFalse($product->published());
    }

    public function testCanNotPublishProductThatDoesNotExist(): void
    {
        $this->expectException(ProductDoesNotExistException::class);
        $this->handler->handle(new UnpublishProductCommand('cool-sku'));
    }
}
