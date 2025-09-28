<?php

namespace App\Identity\Infrastructure\Persistence\Doctrine\Type;

use App\Identity\Domain\Model\Email;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class EmailType extends Type
{

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getStringTypeDeclarationSQL($column);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): Email
    {
        return new Email($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform) : string
    {
        return $value->value();
    }

    public function getName()
    {
        return 'email';
    }
}
