<?php

namespace App\Catalog\Infrastructure\Persistence\Doctrine\Product;

use App\Catalog\Domain\Model\Product\Product;
use App\Catalog\Domain\Model\Product\ProductId;
use App\Catalog\Domain\Model\Product\ProductRepository;
use App\Shared\Domain\Model\SKU;
use Doctrine\ORM\EntityManagerInterface;

class DoctrineProductRepository implements ProductRepository
{
    public function __construct(
        private EntityManagerInterface $em,
        private ProductMapper $mapper,
    ) {
    }

    public function nextIdentity(): ProductId
    {
        return ProductId::create();
    }

    public function add(Product $product): void
    {
        $record = $this->mapper->toRecord($product);

        $this->em->persist($record);
        $this->em->flush();
    }

    public function remove(Product $product): void
    {
        $record = $this->mapper->toRecord($product);
        $this->em->remove($record);
        $this->em->flush();
    }

    public function ofId(ProductId $productId): ?Product
    {
        $product = $this->em->find(ProductRecord::class, $productId);

        return $product ? $this->mapper->toDomain($product) : null;
    }

    public function ofName(string $name): ?Product
    {
        $product = $this->em->getRepository(ProductRecord::class)->findOneBy(['name' => $name]);

        return $product ? $this->mapper->toDomain($product) : null;
    }

    public function ofSku(SKU $sku): ?Product
    {
        $product = $this->em->getRepository(ProductRecord::class)->findOneBy(['sku' => $sku->value()]);

        return $product ? $this->mapper->toDomain($product) : null;
    }

    public function findByFilters(SKU $sku, string $name, int $price, string $categoryName): array
    {
        return [];
    }

    public function ofSkus(array $skus): ?array
    {
        if (empty($skus)) {
            return [];
        }

        $qb = $this->em->createQueryBuilder();
        $qb
            ->select('p')
            ->from(ProductRecord::class, 'p')
            ->where($qb->expr()->in('p.sku', ':skus'))
            ->setParameter('skus', $skus);

        $records = $qb->getQuery()->getResult();

        if (!$records) {
            return [];
        }

        return array_map(
            fn(ProductRecord $record) => $this->mapper->toDomain($record),
            $records
        );
    }
}
