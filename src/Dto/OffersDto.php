<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

readonly class OffersDto
{
    public function __construct(
        #[Assert\NotBlank]
        public string $type,

        /** @var OfferConfigDto[] */
        #[Assert\Valid]
        public array $config,
    ) {}
}