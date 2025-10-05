<?php

namespace App\Catalog\Infrastructure\Persistence\InMemory\Category;

use App\Catalog\Domain\Model\Category\Category;
use App\Catalog\Domain\Model\Category\CategoryId;
use App\Catalog\Domain\Model\Category\CategoryRepository;

class InMemoryCategoryRepository implements CategoryRepository
{
    /**
     * @var array<string, Category>
     */
    private array $categories;
    public function nextIdentity(): CategoryId
    {
        return CategoryId::create();
    }

    public function add(Category $category): void
    {
        $this->categories[$category->id()->id()] = $category;
    }

    public function remove(Category $category): void
    {
        unset($this->categories[$category->id()->id()]);
    }

    public function ofId(CategoryId $categoryId): ?Category
    {
        if (isset($this->categories[$categoryId->id()])) {
            return $this->categories[$categoryId->id()];
        }

        return null;
    }

    public function ofName(string $name): ?Category
    {
        foreach ($this->categories as $category) {
            if ($category->name() === $name) {
                return $category;
            }
        }

        return null;
    }
}
