<?php

namespace App\Service\Offers;


interface OfferStrategyInterface
{
    public function applyOffer(): array;
}