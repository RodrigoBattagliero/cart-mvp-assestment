<?php

namespace App\Handler;

use App\Dto\AddProductToCart;
use App\Dto\CatalogConfigurationDto;
use Symfony\Component\HttpFoundation\RequestStack;

class CartHandler
{
    public function __construct(
        private RequestStack $requestStack,
    ) {}

    public function saveConfiguration(
        CatalogConfigurationDto $dto,
    ): void
    {
        $session = $this->requestStack->getSession();
        $session->set('catalog_config', $dto);
    }

    public function getConfiguration(): ?CatalogConfigurationDto
    {
        $session = $this->requestStack->getSession();
        return $session->get('catalog_config');
    }

    public function unsetConfiguration(): void
    {
        $session = $this->requestStack->getSession();
        $session->set('catalog_config', null);
    }

    public function addItem(AddProductToCart $dto): array
    {
        $session = $this->requestStack->getSession();
        $items = $session->get('items');
        if (!$items || !is_array($items)) {
            $items[$dto->code] = 1;
        } else {
            if (isset($items[$dto->code])) {
                $items[$dto->code] = $items[$dto->code] + 1;
            } else {
                $items[$dto->code] = 1;
            }
        }

        $session->set('items', $items);

        return $items;
    }
}