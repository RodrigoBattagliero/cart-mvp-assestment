<?php

namespace App\Service\Product;

use App\Dto\ProductDto;
use App\Entity\Product;

class ProductFactory
{
    static public function fromDto(ProductDto $dto): Product
    {
        $product = new Product();
        $product->setName($dto->name);
        $product->setCode($dto->code);
        $product->setPrice($dto->price);

        return $product;
    }
}