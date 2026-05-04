<?php

namespace App\Service\Offers;

use App\Dto\ProductDto;

class OfferStrategyDiscountByAmount implements OfferStrategyInterface
{
    public function __construct(
        private int $amount,
        private float $pay,
    )
    {
    }

    public function applyOffer(ProductDto $product, int $totalAmount): array
    {
        $partialTotal = 0;
        while ($totalAmount >= $this->amount) {
            $partialTotal += $product->price * $this->pay;
            $totalAmount -= $this->amount;
        }
        return [$partialTotal, $totalAmount];
    }

}