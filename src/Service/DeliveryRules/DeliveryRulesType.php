<?php

namespace App\Service\DeliveryRules;

class DeliveryRulesType {
    const BETWEEN = 'between';
    const MORE_OR_EQUAL = 'more_or_equal';

    const RULES_CLASSNAME = [
        self::BETWEEN => DeliveryRulesBetween::class,
        self::MORE_OR_EQUAL => DeliveryRulesMoreThan::class,
    ];
}