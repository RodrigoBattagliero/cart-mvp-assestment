<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

readonly class ProductDto
{
    public function __construct(
        #[Assert\NotBlank]
        public string $name,
        
        #[Assert\NotBlank]
        public string $code,
        
        #[Assert\Positive]
        public float $price,
    ) {}
}