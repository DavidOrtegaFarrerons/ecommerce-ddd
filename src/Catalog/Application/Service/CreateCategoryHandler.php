<?php

namespace App\Catalog\Application\Service;

use App\Catalog\Domain\CategoryFactory;
use App\Catalog\Domain\CategoryRepository;

class CreateCategoryHandler
{

    public function __construct(
        private CategoryRepository $categoryRepository,
        private CategoryFactory $categoryFactory,
    )
    {
    }

    public function handle(CreateCategoryCommand $command) : void
    {
        $category = $this->categoryRepository->ofName($command->getName());

        if ($category !== null) {
            throw new CategoryAlreadyExistsException('A category with the name '. $command->getName() .' already exists');
        }

        $category = $this->categoryFactory->create(
            $this->categoryRepository->nextIdentity(),
            $command->getName()
        );

        $this->categoryRepository->add($category);
    }
}
