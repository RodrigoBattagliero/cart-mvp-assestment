<?php

namespace App\Handler;

use App\Dto\AddProductToCart;
use App\Dto\CatalogConfigurationDto;
use App\Dto\ProductDto;
use App\Service\Cart\ItemService;
use App\Service\DeliveryRules\DeliveryRulesService;
use App\Service\Offers\OfferService;
use App\Service\Product\ProductService;
use Symfony\Component\HttpFoundation\RequestStack;

class CartHandler
{
    public function __construct(
        private RequestStack $requestStack,
        private OfferService $offerService,
        private DeliveryRulesService $deliveryRulesService,
        private ProductService $productService,
        private ItemService $itemService,
    ) {}

    public function saveConfiguration(
        CatalogConfigurationDto $dto,
    ): void
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
        $this->productService->deleteAll();
    }

    public function addItem(AddProductToCart $dto): void
    {
        $this->itemService->addItem($dto);
    }

    public function getTotal(): float
    {
        $totalCost = 0;
        $cartItems = $this->itemService->getAll();
        foreach ($cartItems as $item) {
            [$partialCost, $remaningAmount] = $this->offerService->processItem($item);
            
            $totalCost += $partialCost + ($remaningAmount * $item->getProduct()->getPrice());
        }

        //$deliveryCost = $this->deliveryRulesService->getDeliveryCost($catalogConfig->delivery_rules, $totalCost);
        $deliveryCost = 0;
        
        return $totalCost + $deliveryCost;
    }

    private function getProductByCode(array $products, string $code): ?ProductDto
    {
        $product = array_filter($products, function($p) use($code){
            return $code == $p->code;
        });
        if (empty($product)) {
            return null;
        }
        return array_first($product);
    }
}