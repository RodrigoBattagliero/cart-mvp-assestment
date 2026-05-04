<?php

namespace App\Service\Offers;

class OfferType
{
    const DISCOUNT_BY_AMOUNT = 'discount_by_amount';

    const OFFERS_CLASSNAME = [
        self::DISCOUNT_BY_AMOUNT => OfferStrategyDiscountByAmount::class,
    ];
}