<?php

namespace App\Catalog\Domain\Model\Category;


use App\Shared\Domain\UuidId;

class CategoryId extends UuidId {
    public function equalsTo(CategoryId $categoryId): bool
    {
        return $this->id() === $categoryId->id();
    }
}
