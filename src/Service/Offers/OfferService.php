<?php

namespace App\Service\Offers;

use App\Dto\OfferDto;
use App\Dto\ProductDto;

class OfferService
{
    public function __construct(
        private OfferFactory $offerFactory,
    )
    {}
    
    public function processProduct(
        ProductDto $product,
        array $offers,
        int $amount
    ): array
    {
        $partialTotal = 0;
        $offer = $this->getOfferByProduct($product, $offers);
        if ($offer) {
            $offerStrategy = $this->offerFactory->getOfferStrategy($offer);

            return $offerStrategy->applyOffer($product, $amount);            
        }
        
        return [$partialTotal, $amount];
    }

    private function getOfferByProduct(
        ProductDto $product,
        array $offers
    ): ?OfferDto
    {
        if ($offers) {
            foreach ($offers as $offer) {
                if ($offer->product_trigger == $product->code) {
                    return $offer;
                }
            }
        }
        return null;
    }
}