<?php

namespace App\Service\Offers;

use App\Entity\Cart;
use App\Entity\Offer;


interface OfferStrategyInterface
{
    public function applyOffer(Cart $cartItem, Offer $offer,): array;
}