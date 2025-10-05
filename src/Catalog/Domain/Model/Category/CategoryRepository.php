<?php

namespace App\Catalog\Domain\Model\Category;

interface CategoryRepository
{
    public function nextIdentity() : CategoryId;
    public function add(Category $category) : void;
    public function remove(Category $category) : void;
    public function ofId(CategoryId $categoryId) : ?Category;
    public function ofName(string $name) : ?Category;
}
