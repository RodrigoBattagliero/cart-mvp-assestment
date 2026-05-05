<?php

namespace App\Service\DeliveryRules;

use App\Entity\DeliveryRules;

class DeliveryRulesMoreThan implements DeliveryRulesInterface
{
    public function applyDeliveryDiscountRule(DeliveryRules $deliveryRule, float $totalCost): ?float
    {
        if ($totalCost >= $deliveryRule->getParams()[0]) {
            return $deliveryRule->getValue();
        }

        return null;
    }
}