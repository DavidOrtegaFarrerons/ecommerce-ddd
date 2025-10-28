<?php

namespace App\Catalog\Application\Service\Product;

class ViewProductsCommand
{
    /**
     * @var string[]
     */
    private array $skus;

    public function __construct(array $skus)
    {
        $this->skus = $skus;
    }

    public function getSkus(): array
    {
        return $this->skus;
    }
}
