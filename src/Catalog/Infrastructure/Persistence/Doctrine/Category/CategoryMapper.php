<?php

namespace App\Catalog\Infrastructure\Persistence\Doctrine\Category;

use App\Catalog\Domain\Model\Category\Category;
use App\Catalog\Domain\Model\Category\CategoryId;

class CategoryMapper
{
    public static function toRecord(Category $category) : CategoryRecord
    {
        $r          = new CategoryRecord();
        $r->id      = $category->id()->id();
        $r->name    = $category->name();

        return $r;
    }

    public static function toDomain(CategoryRecord $r) : Category
    {
        return new Category(
            CategoryId::create($r->id),
            $r->name
        );
    }
}
