<?php

namespace App\Tests\Identity\Domain;

use App\Identity\Domain\Model\UserId;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

class UserIdTest extends TestCase
{
    public function testGeneratesValidUuidWhenNoneProvided(): void
    {
        $userId = new UserId();

        $this->assertTrue(Uuid::isValid($userId->id()));
    }

    public function testAcceptsValidUuid(): void
    {
        $uuid = Uuid::v4()->toString();
        $userId = new UserId($uuid);

        $this->assertSame($uuid, $userId->id());
    }

    public function testGeneratesNewUuidWhenInvalidUuidPassed(): void
    {
        $userId = new UserId('not-a-uuid');

        $this->assertTrue(Uuid::isValid($userId->id()));
        $this->assertNotSame('not-a-uuid', $userId->id());
    }

    public function testComparesUserIdsCorrectly(): void
    {
        $uuid = Uuid::v4()->toString();
        $userId1 = new UserId($uuid);
        $userId2 = new UserId($uuid);
        $userId3 = new UserId();

        $this->assertTrue($userId1->equalsTo($userId2));
        $this->assertFalse($userId1->equalsTo($userId3));
    }

    public function testCanBeCastToString(): void
    {
        $uuid = Uuid::v4()->toString();
        $userId = new UserId($uuid);

        $this->assertSame($uuid, (string)$userId);
    }

    public function testCreateMethodReturnsNewInstance(): void
    {
        $uuid = Uuid::v4()->toString();
        $userId = (new UserId())->create($uuid);

        $this->assertInstanceOf(UserId::class, $userId);
        $this->assertSame($uuid, $userId->id());
    }
}
