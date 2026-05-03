<?php

namespace App\Handler;

use App\Dto\AddProductToCart;
use App\Dto\CatalogConfigurationDto;
use Symfony\Component\HttpFoundation\RequestStack;

class CartHandler
{
    public function __construct(
        private RequestStack $requestStack,
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
        //dd($catalogConfig);
        $total = 0;
        foreach ($items as $code => $amount) {
            $product = array_filter($catalogConfig->products, function($p) use($code){
                return $code == $p->code;
            });
            if (empty($product)) {
                continue;
            }
            $product = array_first($product);
            if (isset($product)) {
                // offers
                $offers = $catalogConfig->offers;
                $partialTotal = 0;
                if ($offers) {
                    foreach ($offers as $offer) {
                        
                        if ('discount_by_amount' == $offer['type']) {
                            foreach ($offer['config'] as $config) {
                                if ($config['product_trigger'] == $product->code) {
                                    while ($amount >= $config['amount']) {
                                        $partialTotal += $product->price * $config['pay'];
                                        $amount -= $config['amount'];
                                    }
                                }
                            }
                        }
                    }
                }
                $total += $partialTotal + ($amount * $product->price);
            }
        }

        // delivery rules
        $deliveryCost = 0;
        if ($catalogConfig->delivery_rules) {
            foreach ($catalogConfig->delivery_rules as $rule) {
                $ruleKey = \array_keys($rule['rule']);
                switch ($ruleKey[0]) {
                    case 'between':
                        if ($total >= $rule['rule']['between'][0] && $total <=  $rule['rule']['between'][1]) {
                            $deliveryCost = $rule['strategy']['value'];
                        }
                        break;
                    case 'more_than': // TODO: Fix key name to more_or_equal
                        if ($total >= $rule['rule']['more_than'][0]) {
                            $deliveryCost = $rule['strategy']['value'];
                        }
                        break;
                }
            }
        }
       // dd($deliveryCost);
        return $total + $deliveryCost;
        
        
    }
}