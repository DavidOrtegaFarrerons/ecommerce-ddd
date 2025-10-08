<?php

namespace App\Tests\Catalog\Domain\Model\Category;

use App\Catalog\Domain\Model\Category\CategoryId;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

class CategoryIdTest extends TestCase
{
    public function testComparesUserIdsCorrectly(): void
    {
        $uuid = Uuid::v4()->toString();
        $userId1 = CategoryId::create($uuid);
        $userId2 = CategoryId::create($uuid);
        $userId3 = CategoryId::create();

        $this->assertTrue($userId1->equalsTo($userId2));
        $this->assertFalse($userId1->equalsTo($userId3));
    }
}
