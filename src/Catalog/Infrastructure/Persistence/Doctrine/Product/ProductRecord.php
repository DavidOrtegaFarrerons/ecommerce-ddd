<?php

namespace App\Catalog\Infrastructure\Persistence\Doctrine\Product;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity()]
#[ORM\Table(name: '`product`')]
class ProductRecord
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    public ?string $id = null;

    #[ORM\Column(length: 255)]
    public ?string $sku = null;

    #[ORM\Column(length: 255)]
    public ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    public ?string $description = null;

    #[ORM\Column]
    public ?int $priceAmount = null;

    #[ORM\Column(length: 3)]
    public ?string $priceCurrency = null;

    #[ORM\Column]
    public ?string $categoryId = null;

    #[ORM\Column]
    public ?bool $published = null;
}
