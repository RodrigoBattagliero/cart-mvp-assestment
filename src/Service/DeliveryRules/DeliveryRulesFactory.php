<?php

namespace App\Service\DeliveryRules;

use App\Dto\DeliveryRuleDto;

class DeliveryRulesFactory
{
    public function createDeliveryRule(DeliveryRuleDto $deliveryRuleDto): ?DeliveryRulesInterface
    {
        if ($deliveryRuleDto->rule == 'between') {
            return new DeliveryRulesBetween(
                $deliveryRuleDto->params,
                $deliveryRuleDto->type,
                $deliveryRuleDto->value
            );
        } else {
            return new DeliveryRulesMoreThan(
                $deliveryRuleDto->params,
                $deliveryRuleDto->type,
                $deliveryRuleDto->value
            );
        }
    }
}