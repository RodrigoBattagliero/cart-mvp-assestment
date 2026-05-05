<?php

namespace App\Service\Cart;

use App\Dto\AddProductToCart;
use App\Entity\Cart;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ItemService
{
    const DEFAULT_AMOUNT = 1;
    
    public function __construct(
        private EntityManagerInterface $em,
    )
    {
    }

    public function getAll(): array
    {
        return $this->em->getRepository(Cart::class)->findAll();
    }

    public function deleteAll(): void
    {
        $items = $this->getAll();
        foreach ($items as $item) {
            $this->em->remove($item);
        }

        $this->em->flush();
    }

    public function addItem(AddProductToCart $dto): void
    {
        $product = $this->em->getRepository(Product::class)->findOneBy(['code' => $dto->code]);
        if (!$product) {
            throw new NotFoundHttpException('Product not found');
        }
        
        $cartItem = $this->getOrCreateCartItem($product);
        $cartItem->setAmount($cartItem->getAmount() + 1);

        $this->em->persist($cartItem);
        $this->em->flush();
    }

    private function getOrCreateCartItem(Product $product): Cart
    {
        $cartItem = $this->em->getRepository(Cart::class)->findOneBy(['product' => $product]);
        if (!$cartItem) {
            $cartItem = new Cart();
            $cartItem->setProduct($product);
            $cartItem->setAmount(self::DEFAULT_AMOUNT);
        }

        return $cartItem;
    }
}