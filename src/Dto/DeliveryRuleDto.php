<?php

namespace App\Dto;

readonly class DeliveryRuleDto
{
    public function __construct(
        public string $rule,
        public array $params,
        public string $type,
        public float $value,
        
    ) {}
}