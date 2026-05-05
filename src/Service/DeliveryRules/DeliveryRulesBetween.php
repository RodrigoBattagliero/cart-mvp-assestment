<?php 

namespace App\Service\DeliveryRules;

use App\Entity\DeliveryRules;

class DeliveryRulesBetween implements DeliveryRulesInterface
{
    public function applyDeliveryDiscountRule(DeliveryRules $deliveryRule, float $totalCost): ?float
    {
        if ($totalCost >= $deliveryRule->getParams()[0] && $totalCost <= $deliveryRule->getParams()[1]) {
            return $deliveryRule->getValue();
        }

        return null;
    }
}