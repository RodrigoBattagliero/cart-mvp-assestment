<?php 

namespace App\Service\DeliveryRules;

class DeliveryRulesBetween implements DeliveryRulesInterface
{
    public function __construct(
        private array $params,
        private string $type,
        private string $value,
    )
    {
    }

    public function applyDeliveryDiscountRule(float $totalCost): ?float
    {
        if ($totalCost >= $this->params[0] && $totalCost <= $this->params[1]) {
            return $this->value;
        }

        return null;
    }
}