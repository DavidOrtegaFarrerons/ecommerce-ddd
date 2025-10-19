<?php

namespace App\Catalog\Infrastructure\Persistence\Doctrine\Category;

use App\Catalog\Domain\Model\Category\Category;
use App\Catalog\Domain\Model\Category\CategoryId;
use App\Catalog\Domain\Model\Category\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;

class DoctrineCategoryRepository implements CategoryRepository
{
    public function __construct(
        private EntityManagerInterface $em,
        private CategoryMapper $mapper,
    ) {
    }

    public function nextIdentity(): CategoryId
    {
        return CategoryId::create();
    }

    public function add(Category $category): void
    {
        $record = $this->mapper->toRecord($category);

        $this->em->persist($record);
        $this->em->flush();
    }

    public function remove(Category $category): void
    {
        $record = $this->mapper->toRecord($category);

        $this->em->remove($record);
    }

    public function ofId(CategoryId $categoryId): ?Category
    {
        $record = $this->em->find(CategoryRecord::class, $categoryId->id());

        return $record ? $this->mapper->toDomain($record) : null;
    }

    public function ofName(string $name): ?Category
    {
        $record = $this->em->getRepository(CategoryRecord::class)
            ->findOneBy(['name' => $name])
        ;

        return $record ? $this->mapper->toDomain($record) : null;
    }
}
