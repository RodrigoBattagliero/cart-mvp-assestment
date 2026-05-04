<?php

namespace App\Service\Offers;

use App\Dto\OfferDto;
use App\Entity\Offer;
use App\Entity\Product;

class OfferFactory
{
    static public function fromDto(OfferDto $dto, Product $product): Offer
    {
        $offer = new Offer();
        $offer->setType($dto->type);
        $offer->setAmount($dto->amount);
        $offer->setPay($dto->pay);
        $offer->setProduct($product);

        return $offer;
    }
}