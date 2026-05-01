<?php

namespace App\Dto;

readonly class DeliveryRulesDto
{
    public function __construct(
        /** @var array<string, int[]> */
        public array $rule,
        
        public DeliveryStrategyDto $strategy,
    ) {}
}