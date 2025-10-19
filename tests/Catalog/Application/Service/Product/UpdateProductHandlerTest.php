<?php

namespace App\Tests\Catalog\Application\Service\Product;

use App\Catalog\Application\Service\Product\UpdateProductCommand;
use App\Catalog\Application\Service\Product\UpdateProductHandler;
use App\Catalog\Domain\Model\Category\Category;
use App\Catalog\Domain\Model\Category\CategoryDoesNotExistException;
use App\Catalog\Domain\Model\Category\CategoryId;
use App\Catalog\Domain\Model\Product\Product;
use App\Catalog\Domain\Model\Product\ProductDoesNotExistException;
use App\Catalog\Domain\Model\Product\ProductId;
use App\Catalog\Infrastructure\Persistence\InMemory\Category\InMemoryCategoryRepository;
use App\Catalog\Infrastructure\Persistence\InMemory\Product\InMemoryProductRepository;
use App\Shared\Domain\Model\Currency;
use App\Shared\Domain\Model\Money;
use App\Shared\Domain\Model\SKU;
use PHPUnit\Framework\TestCase;

final class UpdateProductHandlerTest extends TestCase
{
    private UpdateProductHandler $handler;
    private InMemoryProductRepository $productRepository;
    private InMemoryCategoryRepository $categoryRepository;

    protected function setUp(): void
    {
        $this->productRepository = new InMemoryProductRepository();
        $this->categoryRepository = new InMemoryCategoryRepository();

        $this->handler = new UpdateProductHandler(
            $this->productRepository,
            $this->categoryRepository,
        );
    }

    public function testItUpdatesAllProductFields(): void
    {
        $oldCategory = new Category(CategoryId::create(), 'old-category');
        $newCategory = new Category(CategoryId::create(), 'new-category');
        $this->categoryRepository->add($oldCategory);
        $this->categoryRepository->add($newCategory);

        $product = Product::create(
            ProductId::create(),
            SKU::create('ABC123'),
            'old-name',
            'old-description',
            Money::create(100, Currency::create('EUR')),
            $oldCategory->id(),
        );
        $this->productRepository->add($product);

        $command = new UpdateProductCommand(
            sku: 'ABC123',
            name: 'new-name',
            description: 'new-description',
            priceAmount: 200,
            priceCurrency: 'USD',
            categoryId: $newCategory->id()->id(),
        );

        // Act
        $this->handler->handle($command);

        // Assert
        $updated = $this->productRepository->ofSku(SKU::create('ABC123'));
        self::assertSame('new-name', $updated->name());
        self::assertSame('new-description', $updated->description());
        self::assertSame(200, $updated->price()->amount());
        self::assertSame('USD', $updated->price()->currency()->isoCode());
        self::assertTrue($updated->categoryId()->equalsTo($newCategory->id()));
    }

    public function testProductMustExistToBeUpdated(): void
    {
        $command = new UpdateProductCommand(
            sku: 'non-existent',
            name: 'whatever'
        );

        $this->expectException(ProductDoesNotExistException::class);
        $this->handler->handle($command);
    }

    public function testCategoryMustExistWhenUpdatingCategory(): void
    {
        $category = new Category(CategoryId::create(), 'existing-category');
        $this->categoryRepository->add($category);

        $product = Product::create(
            ProductId::create(),
            SKU::create('MISSING-CAT'),
            'name',
            'description',
            Money::create(100, Currency::create('EUR')),
            $category->id(),
        );
        $this->productRepository->add($product);

        $nonExistentCategoryId = CategoryId::create();

        $command = new UpdateProductCommand(
            sku: 'MISSING-CAT',
            categoryId: $nonExistentCategoryId->id()
        );

        $this->expectException(CategoryDoesNotExistException::class);
        $this->handler->handle($command);
    }

    public function testItOnlyUpdatesProvidedFields(): void
    {
        $category = new Category(CategoryId::create(), 'category');
        $this->categoryRepository->add($category);

        $product = Product::create(
            ProductId::create(),
            SKU::create('PARTIAL'),
            'old-name',
            'old-description',
            Money::create(100, Currency::create('EUR')),
            $category->id(),
        );
        $this->productRepository->add($product);

        $command = new UpdateProductCommand(
            sku: 'PARTIAL',
            name: 'new-name'
        );

        $this->handler->handle($command);

        $updated = $this->productRepository->ofSku(SKU::create('PARTIAL'));
        self::assertSame('new-name', $updated->name());
        self::assertSame('old-description', $updated->description());
        self::assertSame(100, $updated->price()->amount());
        self::assertSame('EUR', $updated->price()->currency()->isoCode());
    }
}
