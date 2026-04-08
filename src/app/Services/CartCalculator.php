<?php

declare(strict_types=1);

namespace App\Services;

use App\Dto\CartItemDto;
use App\Enums\DeliveryRuleEnum;
use App\Rules\RuleInterface;

readonly class CartCalculator
{
    /**
     * @param RuleInterface[] $discountRules
     * @param array<string, float> $products
     */
    public function __construct(
        private array $discountRules,
        private array $products,
    ) {}

    /**
     * @param CartItemDto[] $items
     */
    public function calculate(array $items): array
    {
        $subtotal = 0.00;
        $itemQuantities = [];

        foreach ($items as $item) {
            $itemQuantities[$item->productCode] = $item->quantity;
            $subtotal += $item->price * $item->quantity;
        }

        $discount = $this->calculateDiscount($itemQuantities);
        $subtotal -= $discount;
        $deliveryCost = DeliveryRuleEnum::resolve($subtotal)->cost();

        return [
            'subtotal' => round($subtotal, 2),
            'discount' => round($discount, 2),
            'delivery' => $deliveryCost,
            'total' => round($subtotal + $deliveryCost, 2),
        ];
    }

    private function calculateDiscount(array $itemQuantities): float
    {
        $discount = 0.00;
        foreach ($this->discountRules as $rule) {
            $discount += $rule->apply($itemQuantities, $this->products);
        }

        return $discount;
    }
}
