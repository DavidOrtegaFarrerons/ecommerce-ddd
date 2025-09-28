<?php

namespace App\Identity\Infrastructure\Persistence\Doctrine\Type;

use App\Identity\Domain\Model\UserId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class UserIdType extends Type
{

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getGuidTypeDeclarationSQL($column);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): UserId
    {
        return new UserId($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform) : string
    {
        if (!$value instanceof UserId) {
            throw new \InvalidArgumentException("Expected instance of UserId, got " . gettype($value));
        }

        return (string) $value;
    }

    public function getName()
    {
        return 'user_id';
    }
}
