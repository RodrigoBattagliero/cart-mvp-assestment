<?php 

namespace App\Controller;

use App\Dto\CatalogConfigurationDto;
use App\Handler\CartHandler;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

class IndexController extends AbstractController
{

    public function __construct(
        private CartHandler $cartHandler,
    ) {}

    #[Route('/api/get', name: 'app_get', methods: ['GET'])]
    public function get(): JsonResponse
    {
        try {
            $dto = $this->cartHandler->getConfiguration();
        } catch (Exception $e) {

        }

        return $this->json($dto);
    }

    #[Route('/api/delete', name: 'app_delete', methods: ['GET'])]
    public function delete(): JsonResponse
    {
        try {
            $this->cartHandler->unsetConfiguration();
        } catch (Exception $e) {

        }

        return $this->json(null);
    }

    #[Route('/api/init', name: 'app_init', methods: ['POST'])]
    public function init(
        #[MapRequestPayload] CatalogConfigurationDto $catalogDto
    ): JsonResponse
    {
        try {
            $this->cartHandler->saveConfiguration($catalogDto);
        } catch (Exception $e) {

        }

        return $this->json(null, 201);
    }

    #[Route('/api/add', name: 'app_add_product', methods: ['POST'])]
    public function addProduct(): JsonResponse
    {

        return $this->json(null, 201);
    }

    #[Route('/api/total', name: 'app_total', methods: ['GET'])]
    public function getTotal(): JsonResponse
    {

        return $this->json(['total' => 1]);
    }
}