<?php

namespace App\Service\Offers;

use App\Entity\Cart;
use App\Entity\Offer;

class OfferStrategyDiscountByAmount implements OfferStrategyInterface
{
    public function __construct(
        private Cart $cartItem,
        private Offer $offer,
    )
    {
    }

    public function applyOffer(): array
    {
        $partialCost = 0;
        $remainingAmount = $this->cartItem->getAmount();
        while ($remainingAmount >= $this->offer->getAmount()) {
            $partialCost += $this->cartItem->getProduct()->getPrice() * $this->offer->getPay();
            $remainingAmount -= $this->cartItem->getAmount();
        }
        return [$partialCost, $remainingAmount];
    }

}