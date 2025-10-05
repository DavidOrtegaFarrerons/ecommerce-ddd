<?php

namespace App\Catalog\Domain\Model\Category;

class CategoryFactory
{
    public function create(CategoryId $id, string $name): Category
    {
        return new Category($id, $name);
    }
}
