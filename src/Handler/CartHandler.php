<?php

namespace App\Handler;

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
}