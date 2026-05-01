<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class OfferConfigDto
{
    public function __construct(
        #[Assert\NotBlank]
        public string $product_trigger,
        
        #[Assert\GreaterThan(0)]
        public int $amount,
        
        #[Assert\PositiveOrZero]
        public float $pay,
    ) {}
}