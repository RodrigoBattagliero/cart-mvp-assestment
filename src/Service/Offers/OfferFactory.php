<?php

namespace App\Service\Offers;

use App\Dto\OfferDto;

class OfferFactory
{
    public function getOfferStrategy(OfferDto $offer): ?OfferStrategyInterface
    {
        $className = OfferType::OFFERS_CLASSNAME[$offer->type];
        
        return new $className(
            $offer->amount,
            $offer->pay
        );
    }
}