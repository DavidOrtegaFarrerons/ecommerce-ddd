<?php

namespace App\Tests\Shared;

use App\Identity\Domain\Model\UserId;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

class UuidIdTest extends TestCase
{
    public function testGeneratesValidUuidWhenNoneProvided(): void
    {
        $userId = UserId::create();

        $this->assertTrue(Uuid::isValid($userId->id()));
    }

    public function testAcceptsValidUuid(): void
    {
        $uuid = Uuid::v4()->toString();
        $userId = UserId::create($uuid);

        $this->assertSame($uuid, $userId->id());
    }

    public function testGeneratesNewUuidWhenInvalidUuidPassed(): void
    {
        $userId = UserId::create('not-a-uuid');

        $this->assertTrue(Uuid::isValid($userId->id()));
        $this->assertNotSame('not-a-uuid', $userId->id());
    }

    public function testComparesUserIdsCorrectly(): void
    {
        $uuid = Uuid::v4()->toString();
        $userId1 = UserId::create($uuid);
        $userId2 = UserId::create($uuid);
        $userId3 = UserId::create();

        $this->assertTrue($userId1->equalsTo($userId2));
        $this->assertFalse($userId1->equalsTo($userId3));
    }

    public function testCanBeCastToString(): void
    {
        $uuid = Uuid::v4()->toString();
        $userId = UserId::create($uuid);

        $this->assertSame($uuid, (string)$userId);
    }

    public function testCreateMethodReturnsNewInstance(): void
    {
        $uuid = Uuid::v4()->toString();
        $userId = UserId::create($uuid);

        $this->assertInstanceOf(UserId::class, $userId);
        $this->assertSame($uuid, $userId->id());
    }
}
