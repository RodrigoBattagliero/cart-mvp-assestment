<?php

namespace App\Service\Offers;

use App\Entity\Cart;
use App\Entity\Offer;

class OfferStrategyFactory
{
    static public function getOfferStrategy(Offer $offer): ?OfferStrategyInterface
    {
        $className = OfferType::OFFERS_CLASSNAME[$offer->getType()];
        
        return new $className();
    }
}