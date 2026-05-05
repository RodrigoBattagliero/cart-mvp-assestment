<?php

namespace App\Dto;

readonly class DeliveryRuleDto
{
    public function __construct(
        public string $rule,
        public array $params,
        public float $value,
        
    ) {}
}