<?php

namespace App\Handler;

use App\Dto\AddProductToCart;
use App\Dto\CatalogConfigurationDto;
use App\Dto\ProductDto;
use App\Service\OfferService;
use Symfony\Component\HttpFoundation\RequestStack;

class CartHandler
{
    public function __construct(
        private RequestStack $requestStack,
        private OfferService $offerService,
    ) {}

    public function saveConfiguration(
        CatalogConfigurationDto $dto,
    ): void
    {
        $session = $this->requestStack->getSession();
        $session->set('catalog_config', $dto);
    }

    public function getConfiguration(): ?CatalogConfigurationDto
    {
        $session = $this->requestStack->getSession();
        dd($session->get('catalog_config'));
        return $session->get('catalog_config');
    }

    public function unsetConfiguration(): void
    {
        $session = $this->requestStack->getSession();
        $session->set('catalog_config', null);
    }

    public function addItem(AddProductToCart $dto): array
    {
        $session = $this->requestStack->getSession();
        $items = $session->get('items');
        if (!$items || !is_array($items)) {
            $items[$dto->code] = 1;
        } else {
            if (isset($items[$dto->code])) {
                $items[$dto->code] = $items[$dto->code] + 1;
            } else {
                $items[$dto->code] = 1;
            }
        }

        $session->set('items', $items);

        return $items;
    }

    public function getTotal()
    {
        $session = $this->requestStack->getSession();
        $items = $session->get('items');
        /** @var CatalogConfigurationDto @catalogConfig  */
        $catalogConfig = $session->get('catalog_config');
        $totalCost = 0;
        foreach ($items as $code => $amount) {
            $product = $this->getProductByCode($catalogConfig->products, $code);
            if (isset($product)) {
                [$partialCost, $remaningAmount] = $this->offerService->processProduct(
                    $product,
                    $catalogConfig->offers,
                    $amount
                );
                
                $totalCost += $partialCost + ($remaningAmount * $product->price);
            }
        }

        // delivery rules
        $deliveryCost = 0;
        if ($catalogConfig->delivery_rules) {
            foreach ($catalogConfig->delivery_rules as $rule) {
                $ruleKey = \array_keys($rule['rule']);
                switch ($ruleKey[0]) {
                    case 'between':
                        if ($totalCost >= $rule['rule']['between'][0] && $totalCost <=  $rule['rule']['between'][1]) {
                            $deliveryCost = $rule['strategy']['value'];
                        }
                        break;
                    case 'more_than': // TODO: Fix key name to more_or_equal
                        if ($totalCost >= $rule['rule']['more_than'][0]) {
                            $deliveryCost = $rule['strategy']['value'];
                        }
                        break;
                }
            }
        }

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