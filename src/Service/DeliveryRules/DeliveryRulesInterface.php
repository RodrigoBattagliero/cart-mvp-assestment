<?php

namespace App\Service\DeliveryRules;

use App\Entity\DeliveryRules;

interface DeliveryRulesInterface
{
    public function applyDeliveryDiscountRule(DeliveryRules $deliveryRule, float $totalCost): ?float;
}