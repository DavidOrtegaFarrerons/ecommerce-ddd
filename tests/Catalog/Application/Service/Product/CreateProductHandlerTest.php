<?php

namespace App\Tests\Catalog\Application\Service\Product;

use App\Catalog\Application\Service\Product\CreateProductCommand;
use App\Catalog\Application\Service\Product\CreateProductHandler;
use App\Catalog\Domain\Event\ProductCreated;
use App\Catalog\Domain\Model\Category\CategoryId;
use App\Catalog\Domain\Model\Product\ProductAlreadyExistsException;
use App\Catalog\Domain\Model\Product\ProductFactory;
use App\Catalog\Domain\Model\Product\ProductRepository;
use App\Catalog\Infrastructure\Persistence\InMemory\Product\InMemoryProductRepository;
use App\Shared\Domain\Model\SKU;
use App\Tests\Shared\FakeEventDispatcher;
use PHPUnit\Framework\TestCase;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class CreateProductHandlerTest extends TestCase
{
    private ProductRepository $repository;
    private CreateProductHandler $handler;

    private EventDispatcherInterface $eventDispatcher;
    protected function setUp(): void
    {
        $this->repository = new InMemoryProductRepository();
        $factory = new ProductFactory();
        $this->eventDispatcher = new FakeEventDispatcher();
        $this->handler = new CreateProductHandler(
            $this->repository,
            $factory,
            $this->eventDispatcher
        );
    }
    public function testProductCanBeCreatedAndEventIsDispatched(): void
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

        $this->assertTrue(
            $this->eventDispatcher->hasEventOfType(ProductCreated::class),
            'Expected a ProductCreated event to be dispatched.'
        );

        $dispatchedEvents = $this->eventDispatcher->dispatchedEvents();
        $this->assertCount(1, $dispatchedEvents);
        $this->assertInstanceOf(ProductCreated::class, $dispatchedEvents[0]);

        /** @var ProductCreated $event */
        $event = $dispatchedEvents[0];
        $this->assertSame('COOL-SKU', $event->sku()->value());
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
