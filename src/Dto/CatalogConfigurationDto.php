<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

readonly class CatalogConfigurationDto
{
    public function __construct(
        /** @var ProductDto[] */
        #[Assert\Valid]
        public array $products,

        /** @var DeliveryRuleDto[] */
        #[Assert\Valid]
        public array $delivery_rules,

        /** @var OfferDto[] */
        #[Assert\Valid]
        public array $offers,
    ) {}
}