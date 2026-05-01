<?php 

namespace App\Controller;

use App\Dto\CatalogConfigurationDto;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

class IndexController extends AbstractController
{
    #[Route('/api/init', name: 'app_init', methods: ['POST'])]
    public function init(
        #[MapRequestPayload] CatalogConfigurationDto $catalogDto
    ): JsonResponse
    {
        dd($catalogDto);
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