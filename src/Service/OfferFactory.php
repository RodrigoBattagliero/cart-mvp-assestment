<?php

namespace App\Service;

use App\Dto\OfferDto;

class OfferFactory
{
    public function getOfferStrategy(OfferDto $offer): ?OfferStrategyInterface
    {
        if ($offer->type == 'discount_by_amount') {
            return new OfferStrategyDiscountByAmount(
                $offer->amount,
                $offer->pay
            );
        }
        return null;
    }
}