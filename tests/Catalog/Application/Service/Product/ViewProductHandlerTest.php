<?php

namespace App\Tests\Catalog\Application\Service\Product;

use App\Catalog\Application\Service\Product\ViewProductCommand;
use App\Catalog\Application\Service\Product\ViewProductHandler;
use App\Catalog\Application\Transformer\Product\ProductViewAssembler;
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

final class ViewProductHandlerTest extends TestCase
{
    private ViewProductHandler $handler;
    private InMemoryProductRepository $productRepository;
    private InMemoryCategoryRepository $categoryRepository;

    protected function setUp(): void
    {
        $this->productRepository = new InMemoryProductRepository();
        $this->categoryRepository = new InMemoryCategoryRepository();

        $this->handler = new ViewProductHandler(
            $this->productRepository,
            $this->categoryRepository,
            new ProductViewAssembler()
        );
    }

    public function testItReturnsValidProductView(): void
    {
        $category = new Category(CategoryId::create(), 'category');
        $this->categoryRepository->add($category);

        $product = new Product(
            ProductId::create(),
            SKU::create('ABC123'),
            'name',
            'description',
            Money::create(
                100,
                Currency::create('EUR')
            ),
            $category->id(),
        );
        $this->productRepository->add($product);

        $command = new ViewProductCommand('ABC123');

        $view = $this->handler->handle($command);

        self::assertSame('ABC123', $view->sku);
        self::assertSame('name', $view->name);
        self::assertSame('description', $view->description);
        self::assertSame('100', $view->price);
        self::assertSame('EUR', $view->currency);
        self::assertSame($category->name(), $view->categoryName);
    }

    public function testProductMustExistToBeViewed(): void
    {
        $this->expectException(ProductDoesNotExistException::class);

        $command = new ViewProductCommand('not-found');
        $this->handler->handle($command);
    }

    public function testProductMustHaveExistingCategoryToBeViewed(): void
    {
        $product = new Product(
            ProductId::create(),
            SKU::create('missing-category'),
            'name',
            'description',
            Money::create(
                100,
                Currency::create('EUR')
            ),
            CategoryId::create(),
        );
        $this->productRepository->add($product);

        $command = new ViewProductCommand('missing-category');


        $this->expectException(CategoryDoesNotExistException::class);
        $this->handler->handle($command);
    }
}
