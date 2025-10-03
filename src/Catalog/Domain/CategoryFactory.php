<?php

namespace App\Catalog\Domain;

class CategoryFactory
{
    public function create(CategoryId $id, string $name): Category
    {
        return new Category($id, $name);
    }
}
