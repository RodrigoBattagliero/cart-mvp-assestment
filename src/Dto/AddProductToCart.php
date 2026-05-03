<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class AddProductToCart
{
    public function __construct(
        #[Assert\NotBlank]
        public string $code
    )
    {
    }
}