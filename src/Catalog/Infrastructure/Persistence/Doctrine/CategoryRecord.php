<?php

namespace App\Catalog\Infrastructure\Persistence\Doctrine;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: '`category`')]
class CategoryRecord
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    public ?string $id = null;

    #[ORM\Column(length: 255)]
    public ?string $name = null;
}
