<?php

namespace App\Tests\Catalog\Application\Service\Product;

use App\Catalog\Application\Service\Product\CreateProductCommand;
use App\Catalog\Application\Service\Product\CreateProductHandler;
use App\Catalog\Domain\Model\Category\CategoryId;
use App\Catalog\Domain\Model\Product\Product;
use App\Catalog\Domain\Model\Product\ProductAlreadyExistsException;
use App\Catalog\Domain\Model\Product\ProductFactory;
use App\Catalog\Domain\Model\Product\ProductId;
use App\Catalog\Domain\Model\Product\ProductRepository;
use App\Catalog\Domain\Model\Product\SKU;
use App\Catalog\Infrastructure\Persistence\InMemory\Product\InMemoryProductRepository;
use App\Shared\Domain\Currency;
use App\Shared\Domain\Money;
use PHPUnit\Framework\TestCase;

class CreateProductHandlerTest extends TestCase
{
    private ProductRepository $repository;
    private CreateProductHandler $handler;
    protected function setUp(): void
    {
        $this->repository = new InMemoryProductRepository();
        $factory = new ProductFactory();
        $this->handler = new CreateProductHandler(
            $this->repository,
            $factory
        );
    }
    public function testProductCanBeCreated(): void
    {
        $categoryId = CategoryId::create();
        $command = new CreateProductCommand(
            SKU::create('cool-sku'),
            'name',
            'description',
                100,
            'EUR',
            $categoryId,
        );

        $this->handler->handle($command);

        $createdProduct = $this->repository->ofName('name');

        $this->assertSame('COOL-SKU', $createdProduct->sku()->value());
        $this->assertSame('name', $createdProduct->name());
        $this->assertSame('description', $createdProduct->description());
        $this->assertSame(100, $createdProduct->price()->amount());
        $this->assertSame('EUR', $createdProduct->price()->currency()->isoCode());
        $this->assertSame($categoryId->id(), $createdProduct->categoryId()->id());
    }

    public function testProductWithSameNameCanNotBeCreated(): void
    {
        $categoryId = CategoryId::create();
        $command = new CreateProductCommand(
            SKU::create('cool-sku'),
            'name',
            'description',
            100,
            'EUR',
            $categoryId,
        );

        $this->handler->handle($command);

        $this->expectException(ProductAlreadyExistsException::class);

        $this->handler->handle($command);
    }

    public function testProductWithSameSKUCanNotBeCreated(): void
    {
        $categoryId = CategoryId::create();
        $command = new CreateProductCommand(
            SKU::create('cool-sku'),
            'name',
            'description',
            100,
            'EUR',
            $categoryId,
        );

        $this->handler->handle($command);

        $this->expectException(ProductAlreadyExistsException::class);

        $command = new CreateProductCommand(
            SKU::create('cool-sku'),
            'different name',
            'description',
            100,
            'EUR',
            $categoryId,
        );

        $this->handler->handle($command);
    }
}
