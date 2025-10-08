<?php

namespace App\Tests\Catalog\Application\Service\Category;

use App\Catalog\Application\Service\Category\CreateCategoryCommand;
use App\Catalog\Application\Service\Category\CreateCategoryHandler;
use App\Catalog\Domain\Model\Category\CategoryAlreadyExistsException;
use App\Catalog\Domain\Model\Category\CategoryFactory;
use App\Catalog\Infrastructure\Persistence\InMemory\Category\InMemoryCategoryRepository;
use PHPUnit\Framework\TestCase;

class CreateCategoryHandlerTest extends TestCase
{
    private InMemoryCategoryRepository $repository;
    private CreateCategoryHandler $handler;

    protected function setUp(): void
    {
        $repository = new InMemoryCategoryRepository();
        $this->repository = $repository;

        $factory = new CategoryFactory();

        $this->handler = new CreateCategoryHandler($repository, $factory);


    }
    public function testCategoryGetsCreated()
    {
        $command = new CreateCategoryCommand(
            'new category'
        );

        $this->handler->handle($command);

        $createdCategory = $this->repository->ofName('new category');
        $this->assertNotNull($createdCategory);

        $this->assertSame('new category', $createdCategory->name());
    }

    public function testThrowsExceptionWhenCategoryWithSameNameAlreadyExists()
    {
        $command = new CreateCategoryCommand(
            'new category'
        );

        $this->handler->handle($command);

        $this->expectException(CategoryAlreadyExistsException::class);
        $this->handler->handle($command);
    }
}
