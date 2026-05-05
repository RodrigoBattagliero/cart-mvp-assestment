<?php

namespace App\Service\DeliveryRules;

use App\Entity\DeliveryRules;
use Doctrine\ORM\EntityManagerInterface;

class DeliveryRulesService
{
    public function __construct(
        private EntityManagerInterface $em
    )
    {
    }

    public function saveDeliveryRules(array $deliveryRulesDto): void
    {
        foreach ($deliveryRulesDto as $dto) {
            $deliveryRule = DeliveryRulesFactory::fromDto($dto);
            $this->em->persist($deliveryRule);
        }

        $this->em->flush();
    }

    public function getAll(): ?array
    {
        return $this->em->getRepository(DeliveryRules::class)->findAll();
    }

    public function deleteAll(): void
    {
        $rules = $this->getAll();
        foreach ($rules as $rule) {
            $this->em->remove($rule);
        }

        $this->em->flush();
    }

    public function getDeliveryCost(float $totalCost): float 
    {
        $deliveryRules = $this->getAll();
        if ($deliveryRules) {
            foreach ($deliveryRules as $rule) {
                $deliveryRule = DeliveryRulesStrategyFactory::createDeliveryRule($rule);
                $deliveryCost = $deliveryRule->applyDeliveryDiscountRule($rule, $totalCost);
                
                if ($deliveryCost !== null) {
                    return $deliveryCost;
                }
            }
        }

        return 0;
    }
}