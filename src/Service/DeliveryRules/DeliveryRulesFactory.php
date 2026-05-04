<?php

namespace App\Service\DeliveryRules;

use App\Dto\DeliveryRuleDto;

class DeliveryRulesFactory
{
    public function createDeliveryRule(DeliveryRuleDto $deliveryRuleDto): ?DeliveryRulesInterface
    {
        $className = DeliveryRulesType::RULES_CLASSNAME[$deliveryRuleDto->rule];
        
        return new $className(
            $deliveryRuleDto->params,
            $deliveryRuleDto->value
        );
    }
}