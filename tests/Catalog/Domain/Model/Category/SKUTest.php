<?php

namespace App\Tests\Catalog\Domain\Model\Category;

use App\Catalog\Domain\Model\Product\InvalidSKUException;
use App\Catalog\Domain\Model\Product\SKU;
use PHPUnit\Framework\TestCase;

class SKUTest extends TestCase
{
    public function testValidSkuIsAccepted(): void
    {
        $sku = SKU::create('ABC-123');
        $this->assertSame('ABC-123', $sku->value());
    }

    public function testSkuIsNormalizedToUppercase(): void
    {
        $sku = SKU::create('abc-123');
        $this->assertSame('ABC-123', $sku->value());
    }

    public function testInvalidSkuThrowsException(): void
    {
        $this->expectException(InvalidSKUException::class);
        SKU::create('invalid sku'); // contains space
    }

    public function testNullValueCreatesFakeSku(): void
    {
        $sku = SKU::create(null);
        $this->assertMatchesRegularExpression('/^SKU-[A-F0-9]{16}$/', $sku->value());
    }

    public function testEmptyStringCreatesFakeSku(): void
    {
        $sku = SKU::create('');
        $this->assertMatchesRegularExpression('/^SKU-[A-F0-9]{16}$/', $sku->value());
    }

    public function testEqualityReturnsTrueForSameValue(): void
    {
        $sku1 = SKU::create('ABC-123');
        $sku2 = SKU::create('ABC-123');

        $this->assertTrue($sku1->equalsTo($sku2));
    }

    public function testEqualityReturnsFalseForDifferentValues(): void
    {
        $sku1 = SKU::create('ABC-123');
        $sku2 = SKU::create('DEF-456');

        $this->assertFalse($sku1->equalsTo($sku2));
    }

    public function testToStringReturnsSameValue(): void
    {
        $sku = SKU::create('ABC-123');
        $this->assertSame($sku->value(), (string) $sku);
    }
}
