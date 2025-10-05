<?php

namespace App\Tests\Catalog\Domain\Model\Category;

use App\Catalog\Domain\Model\Category\Category;
use App\Catalog\Domain\Model\Category\CategoryId;
use App\Catalog\Domain\Model\Category\InvalidCategoryNameException;
use PHPUnit\Framework\TestCase;

class CategoryTest extends TestCase
{
    public function testCategoryKeepsGivenId(): void
    {
        $id = CategoryId::create();
        $category = new Category($id, 'Valid Name');

        $this->assertSame($id, $category->id());
    }
    public function testCategoryWithSpacesIsTrimmed() : void
    {
        $category = new Category(CategoryId::create(), '   new-category   ');
        $this->assertSame($category->name(), 'new-category');
    }

    public function testCategoryWithInvalidNameThrowsException() : void
    {
        $this->expectException(InvalidCategoryNameException::class);
        new Category(CategoryId::create(), 'abc');
    }

    public function testCategoryWithNameOfFourCharactersIsValid(): void
    {
        $category = new Category(CategoryId::create(), 'abcd');
        $this->assertSame('abcd', $category->name());
    }
}
