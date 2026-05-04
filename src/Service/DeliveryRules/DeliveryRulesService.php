<?php

namespace App\Service\DeliveryRules;

class DeliveryRulesService
{
    public function __construct(
        private DeliveryRulesFactory $deliveryRuleFactory,
    )
    {
    }

    public function getDeliveryCost(?array $deliveryRules, float $totalCost): float 
    {
        if ($deliveryRules) {

            foreach ($deliveryRules as $rule) {
                $deliveryRule = $this->deliveryRuleFactory->createDeliveryRule($rule);
                $deliveryCost = $deliveryRule->applyDeliveryDiscountRule($totalCost);
                
                if ($deliveryCost !== null) {
                    return $deliveryCost;
                }
            }
        }

        return 0;
    }
}