<?php

namespace App\Inventory\Infrastructure\Persistence\Doctrine;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity()]
#[ORM\Table(name: '`stockItem`')]
class StockItemRecord
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    public ?string $id = null;

    #[ORM\Column(length: 255)]
    public ?string $sku = null;

    #[ORM\Column(type: Types::INTEGER)]
    public ?int $quantity = null;
}
