<?php

namespace App\Service\DeliveryRules;

class DeliveryRulesMoreThan implements DeliveryRulesInterface
{
    public function __construct(
        private array $params,
        private float $value,
    )
    {
    }

    public function applyDeliveryDiscountRule(float $totalCost): ?float
    {
        if ($totalCost >= $this->params[0]) {
            return $this->value;
        }

        return null;
    }
}