<?php

namespace App\Service\Offers;

use App\Dto\ProductDto;

interface OfferStrategyInterface
{
    public function applyOffer(ProductDto $product, int $totalAmount): array;
}