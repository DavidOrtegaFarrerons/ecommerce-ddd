<?php

namespace App\Catalog\Domain;

class Category
{
    private CategoryId $categoryId;
    private string $name;

    /**
     * @param CategoryId $categoryId
     * @param string $name
     */
    public function __construct(CategoryId $categoryId, string $name)
    {
        $this->categoryId = $categoryId;
        $this->name = $name;
    }

    private function setName($name) : void
    {
        $name = trim($name);

        if (strlen($name) < 4) {
            throw new InvalidCategoryNameException("The name of a category should be of at least 4 characters.");
        }

        $this->name = $name;
    }

    public function id() : CategoryId
    {
        return $this->categoryId;
    }

    public function name() : string
    {
        return $this->name;
    }
}
