<?php

namespace App\Dto;

readonly class DiscountByAmountDto
{
    public function __construct(
        public string $product_trigger,
        public int $amount,
        public float $pay,
    ) {}
}