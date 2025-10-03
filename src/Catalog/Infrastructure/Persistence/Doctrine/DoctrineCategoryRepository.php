<?php

namespace App\Catalog\Infrastructure\Persistence\Doctrine;

use App\Catalog\Domain\Category;
use App\Catalog\Domain\CategoryId;
use App\Catalog\Domain\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;

class DoctrineCategoryRepository implements CategoryRepository
{


    public function __construct(private EntityManagerInterface $em)
    {
    }

    public function nextIdentity(): CategoryId
    {
        return CategoryId::create();
    }

    public function add(Category $category): void
    {
        $record = CategoryMapper::toRecord($category);

        $this->em->persist($record);
        $this->em->flush();

    }

    public function remove(Category $category): void
    {
        $record = CategoryMapper::toRecord($category);

        $this->em->remove($record);
    }

    public function ofId(CategoryId $categoryId): ?Category
    {
        $record = $this->em->find(CategoryRecord::class, $categoryId);

        return $record ? CategoryMapper::toDomain($record) : null;
    }

    public function ofName(string $name): ?Category
    {
        $record = $this->em->getRepository(CategoryRecord::class)
            ->findOneBy(['name' => $name])
        ;

        return $record ? CategoryMapper::toDomain($record) : null;
    }
}
