<?php

namespace App\Catalog\Infrastructure\Persistence\Doctrine\Product;

use App\Catalog\Domain\Model\Product\Product;
use App\Catalog\Domain\Model\Product\ProductId;
use App\Catalog\Domain\Model\Product\ProductRepository;
use App\Catalog\Domain\Model\Product\SKU;
use Doctrine\ORM\EntityManagerInterface;

class DoctrineProductRepository implements ProductRepository
{


    public function __construct(private EntityManagerInterface $em)
    {
    }

    public function nextIdentity(): ProductId
    {
        return ProductId::create();
    }

    public function add(Product $product): void
    {
        $record = ProductMapper::toRecord($product);

        if (!$this->ofId($product->id())) { //TODO Check if there is a better way of doing this
            $this->em->persist($record);
        }

        $this->em->flush();
    }

    public function remove(Product $product): void
    {
        $record = ProductMapper::toRecord($product);
        $this->em->remove($record);
        $this->em->flush();
    }

    public function ofId(ProductId $productId): ?Product
    {
        $product = $this->em->find(ProductRecord::class, $productId);

        return $product ? ProductMapper::toDomain($product) : null;
    }

    public function ofName(string $name): ?Product
    {
        $product = $this->em->getRepository(ProductRecord::class)->findOneBy(['name' => $name]);

        return $product ? ProductMapper::toDomain($product) : null;
    }

    public function ofSKU(SKU $sku): ?Product
    {
        $product = $this->em->getRepository(ProductRecord::class)->findOneBy(['sku' => $sku->value()]);

        return $product ? ProductMapper::toDomain($product) : null;
    }
}
