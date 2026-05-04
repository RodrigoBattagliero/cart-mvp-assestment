<?php

namespace App\Service\DeliveryRules;

interface DeliveryRulesInterface
{
    public function applyDeliveryDiscountRule(float $totalCost): ?float;
}