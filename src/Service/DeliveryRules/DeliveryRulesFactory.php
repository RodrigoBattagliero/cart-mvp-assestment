<?php

namespace App\Service\DeliveryRules;

use App\Dto\DeliveryRuleDto;
use App\Entity\DeliveryRules;

class DeliveryRulesFactory
{
    static function fromDto(DeliveryRuleDto $dto): DeliveryRules
    {
        $deliveryRule = new DeliveryRules();
        $deliveryRule->setRule($dto->rule);
        $deliveryRule->setParams($dto->params);
        $deliveryRule->setValue($dto->value);

        return $deliveryRule;
    }
}