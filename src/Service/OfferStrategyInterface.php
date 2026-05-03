<?php

namespace App\Service;

use App\Dto\ProductDto;

interface OfferStrategyInterface
{
    public function applyOffer(ProductDto $product, int $totalAmount): array;
}