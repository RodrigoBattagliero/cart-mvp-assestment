<?php

namespace App\Service\Cart;

use App\Dto\AddProductToCart;
use App\Entity\Cart;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;

class ItemService
{
    public function __construct(
        private EntityManagerInterface $em,
    )
    {
    }

    public function getAll(): array
    {
        return $this->em->getRepository(Cart::class)->findAll();
    }

    public function addItem(AddProductToCart $dto): void
    {
        $product = $this->em->getRepository(Product::class)->findOneBy(['code' => $dto->code]);
        if (!$product) {
            // TODO: exception
        }
        
        $cartItem = $this->updateOrCreateCartItem($product);

        $this->em->persist($cartItem);
        $this->em->flush();
    }

    private function updateOrCreateCartItem(Product $product): Cart
    {
        $cartItem = $this->em->getRepository(Cart::class)->findOneBy(['product' => $product]);
        if (!$cartItem) {
            $cartItem = new Cart();
            $cartItem->setProduct($product);
            $cartItem->setAmount(1);
        } else {
            $cartItem->setAmount($cartItem->getAmount() + 1);
        }

        return $cartItem;
    }
}