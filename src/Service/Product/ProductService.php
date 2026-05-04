<?php

namespace App\Service\Product;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;

class ProductService
{

    public function __construct(
        private EntityManagerInterface $em,
    )
    {
    }
    
    public function saveProducts(array $products): void
    {
        foreach ($products as $product) {
            $product = ProductFactory::fromDto($product);
            $this->em->persist($product);
        }
        $this->em->flush();
    }

    public function getAll(): ?array
    {
        return $this->em->getRepository(Product::class)->findAll();
    }

    public function deleteAll(): void
    {
        $products = $this->getAll();
        foreach ($products as $prodcut) {
            $this->em->remove($prodcut);
        }

        $this->em->flush();
    }
}