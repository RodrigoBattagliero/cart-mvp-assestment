<?php 

namespace App\Controller;

use App\Dto\AddProductToCart;
use App\Dto\CatalogConfigurationDto;
use App\Handler\CartHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

class IndexController extends AbstractController
{
    public function __construct(
        private CartHandler $cartHandler,
    ) {}

    #[Route('/api/get-data', name: 'app_get', methods: ['GET'])]
    public function get(): JsonResponse
    {
        return $this->json($this->cartHandler->getConfiguration());
    }

    #[Route('/api/delete-data', name: 'app_delete', methods: ['DELETE'])]
    public function delete(): JsonResponse
    {
        $this->cartHandler->unsetConfiguration();

        return $this->json(null);
    }

    #[Route('/api/save-data', name: 'app_configuration_save', methods: ['POST'])]
    public function init(
        #[MapRequestPayload] CatalogConfigurationDto $catalogDto
    ): JsonResponse
    {
        $this->cartHandler->saveConfiguration($catalogDto);

        return $this->json(null, 201);
    }

    #[Route('/api/add-item', name: 'app_add_product', methods: ['PUT'])]
    public function addProduct(
        #[MapRequestPayload] AddProductToCart $addProductToCart
    ): JsonResponse
    {
        $this->cartHandler->addItem($addProductToCart);

        return $this->json([]);
    }

    #[Route('/api/get-total', name: 'app_total', methods: ['GET'])]
    public function getTotal(): JsonResponse
    {
        return $this->json([
            'total' => $this->cartHandler->getTotal()
        ]);
    }
}