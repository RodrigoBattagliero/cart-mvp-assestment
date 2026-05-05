<?php

namespace App\Handler;

use App\Dto\AddProductToCart;
use App\Dto\CatalogConfigurationDto;
use App\Service\Cart\ItemService;
use App\Service\DeliveryRules\DeliveryRulesService;
use App\Service\Offers\OfferService;
use App\Service\Product\ProductService;

class CartHandler
{
    public function __construct(
        private OfferService $offerService,
        private DeliveryRulesService $deliveryRulesService,
        private ProductService $productService,
        private ItemService $itemService,
    ) {}

    public function saveConfiguration(CatalogConfigurationDto $dto): void
    {
        $this->productService->saveProducts($dto->products);
        $this->offerService->saveOffers($dto->offers);
        $this->deliveryRulesService->saveDeliveryRules($dto->delivery_rules);
    }

    public function getConfiguration(): array
    {
        return [
            'product' => $this->productService->getAll(),
            'service' => $this->offerService->getAll(),
            'delivery_rules' => $this->deliveryRulesService->getAll(),
            'cart_items' => $this->itemService->getAll(),
        ];
    }

    public function unsetConfiguration(): void
    {
        $this->deliveryRulesService->deleteAll();
        $this->offerService->deleteAll();
        $this->itemService->deleteAll();
        $this->productService->deleteAll();
    }

    public function addItem(AddProductToCart $dto): void
    {
        $this->itemService->addItem($dto);
    }

    public function getTotal(): float
    {
        $totalCost = 0;
        $deliveryCost = 0;
        $cartItems = $this->itemService->getAll();
        if ($cartItems) {
            foreach ($cartItems as $item) {
                $partialCost = $this->offerService->processItem($item);
                $totalCost += $partialCost + ($item->getAmount() * $item->getProduct()->getPrice());
            }
    
            $deliveryCost = $this->deliveryRulesService->getDeliveryCost($totalCost);

        }
        
        return round($totalCost + $deliveryCost, 2);
    }
}