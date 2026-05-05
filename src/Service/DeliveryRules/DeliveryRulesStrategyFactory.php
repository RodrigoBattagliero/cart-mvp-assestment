<?php

namespace App\Service\DeliveryRules;

use App\Entity\DeliveryRules;

class DeliveryRulesStrategyFactory
{
    static public function createDeliveryRule(DeliveryRules $deliveryRule): ?DeliveryRulesInterface
    {
        $className = DeliveryRulesType::RULES_CLASSNAME[$deliveryRule->getRule()];
        
        return new $className();
    }
}