<?php

namespace App\Inventory\Infrastructure\Persistence\Doctrine;

use App\Inventory\Domain\Model\StockItem;
use App\Inventory\Domain\Model\StockItemId;
use App\Inventory\Domain\Model\StockItemRepository;
use App\Shared\Domain\Model\SKU;
use Doctrine\ORM\EntityManagerInterface;

class DoctrineStockItemRepository implements StockItemRepository
{
    public function __construct(
        private EntityManagerInterface $em,
        private StockItemMapper $mapper,
    ) {
    }

    public function nextIdentity(): StockItemId
    {
        return StockItemId::create();
    }

    public function add(StockItem $stockItem)
    {
        $record = $this->mapper->toRecord($stockItem);

        $this->em->persist($record);
        $this->em->flush();
    }

    public function remove(StockItem $stockItem)
    {
        $record = $this->mapper->toRecord($stockItem);

        $this->em->remove($record);
        $this->em->flush();
    }

    public function ofId(StockItemId $stockItemId): ?StockItem
    {
        $record = $this->em->find(StockItemRecord::class, $stockItemId);

        return null !== $record ? $this->mapper->toDomain($record) : null;
    }

    public function ofSku(SKU $sku): ?StockItem
    {
        $record = $this->em->getRepository(StockItemRecord::class)->findOneBy(['sku' => $sku->value()]);

        return null !== $record ? $this->mapper->toDomain($record) : null;
    }
}
