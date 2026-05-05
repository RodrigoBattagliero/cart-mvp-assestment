<?php

namespace App\Service\Offers;

use App\Entity\Cart;
use App\Entity\Offer;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;

class OfferService
{
    public function __construct(
        private EntityManagerInterface $em,
    )
    {
    }

    public function saveOffers(array $offersDto): void
    {
        foreach ($offersDto as $dto) {
            $offer = OfferFactory::fromDto(
                $dto, 
                $this->em->getRepository(Product::class)->findOneBy(['code' => $dto->product_trigger])
            );

            $this->em->persist($offer);
        }

        $this->em->flush();
    }

    public function getAll(): ?array
    {
        return $this->em->getRepository(Offer::class)->findAll();
    }

    public function deleteAll(): void
    {
        $offers = $this->getAll();
        foreach ($offers as $offer) {
            $this->em->remove($offer);
        }

        $this->em->flush();
    }
    
    public function processItem(Cart $cartItem): array
    {
        $offer = $this->em->getRepository(Offer::class)->findOneBy(['product' => $cartItem->getProduct()]);
        if (!$offer) {
            return [0, $cartItem->getAmount()];
        }

        $offerStrategy = OfferStrategyFactory::getOfferStrategy($offer);

        return $offerStrategy->applyOffer($cartItem, $offer);
    }
}