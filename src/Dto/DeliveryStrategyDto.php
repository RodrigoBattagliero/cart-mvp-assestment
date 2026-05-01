<?php

namespace App\Dto;

readonly class DeliveryStrategyDto
{
    public function __construct(
        public string $type,
        public float $value,
    ) {}
}