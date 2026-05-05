<?php

namespace App\Service\Offers;

use App\Entity\Cart;
use App\Entity\Offer;

class OfferStrategyDiscountByAmount implements OfferStrategyInterface
{
    public function applyOffer(Cart $cartItem,Offer $offer,): array
    {
        $partialCost = 0;
        $remainingAmount = $cartItem->getAmount();
        while ($remainingAmount >= $offer->getAmount()) {
            $partialCost += $cartItem->getProduct()->getPrice() * $offer->getPay();
            $remainingAmount -= $cartItem->getAmount();
        }
        return [$partialCost, $remainingAmount];
    }

}