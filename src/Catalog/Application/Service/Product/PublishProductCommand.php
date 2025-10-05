<?php

namespace App\Catalog\Application\Service\Product;

class PublishProductCommand
{
    private string $sku;

    /**
     * @param string $sku
     */
    public function __construct(string $sku)
    {
        $this->sku = $sku;
    }

    public function getSku(): string
    {
        return $this->sku;
    }
}
