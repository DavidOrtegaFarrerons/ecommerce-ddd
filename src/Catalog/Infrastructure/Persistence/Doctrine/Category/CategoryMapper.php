<?php

namespace App\Catalog\Infrastructure\Persistence\Doctrine\Category;

use App\Catalog\Domain\Model\Category\Category;
use App\Catalog\Domain\Model\Category\CategoryId;
use Doctrine\ORM\EntityManagerInterface;

class CategoryMapper
{

    public function __construct(private EntityManagerInterface $em)
    {
    }

    public function toRecord(Category $category) : CategoryRecord
    {
        $r = $this->em->find(CategoryRecord::class, $category->id()->id());
        if ($r === null) {
            $r = new CategoryRecord();
            $r->id = $category->id()->id();
        }

        $r->name = $category->name();

        return $r;
    }

    public function toDomain(CategoryRecord $r) : Category
    {
        return new Category(
            CategoryId::create($r->id),
            $r->name
        );
    }
}
