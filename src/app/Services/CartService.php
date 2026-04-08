<?php

declare(strict_types=1);

namespace App\Services;

use App\Dto\CartDto;
use App\Dto\CartItemDto;
use App\Repositories\CartRepository;
use App\Repositories\ProductRepository;
use App\Rules\DeliveryRule;

readonly class CartService
{
    private array $products;
    
    public function __construct(
        private CartRepository $cartRepository,
        private ProductRepository $productRepository,
        private array $rules
    ) {
        $this->products = $this->productRepository->getAllProducts();
    }

    public function addItem(int $cartId, string $productCode, int $quantity): CartDto
    {
        if (!$this->cartRepository->exists($cartId)) {
            $cartId = $this->cartRepository->create();
        }

        $this->cartRepository->addItem($cartId, $productCode, $quantity);
        $cartItems = $this->cartRepository->findWithItems($cartId);

        return $this->getDto($cartId, $cartItems);
    }

    public function getTotal(int $cartId): array
    {
        $this->assertCartExists($cartId);
        
        $cartItems = $this->cartRepository->findWithItems($cartId);
        $dto = $this->getDto($cartId, $cartItems);

        $itemQuantities = [];
        $subtotal = 0.00;
        foreach ($dto->items as $item) {
            $itemQuantities[$item->productCode] = $item->quantity;
            $subtotal += $item->price * $item->quantity;
        }

        $discount = $this->calculateDiscount($itemQuantities);
        $subtotal -= $discount;
        $deliveryRule = DeliveryRule::resolve($subtotal);
        $deliveryCost = DeliveryRule::cost($deliveryRule);

        return [
            'subtotal' => round($subtotal, 2),
            'discount' => round($discount, 2),
            'delivery' => $deliveryCost,
            'total' => round($subtotal + $deliveryCost, 2),
            'cart' => $dto->toArray(),
        ];
    }

    public function deleteCart(int $cartId): void
    {
        $this->assertCartExists($cartId);

        $this->cartRepository->delete($cartId);
    }

    private function assertCartExists(int $cartId): void
    {
        if (!$this->cartRepository->exists($cartId)) {
            throw new \RuntimeException('Cart not found', 404);
        }
    }

    private function calculateDiscount(array $itemQuantities): float
    {
        $discount = 0.00;
        foreach ($this->rules as $rule) {
            $discount += $rule->apply($itemQuantities, $this->products);
        }

        return $discount;
    }

    private function getDto(int $cartId, array $cartItems): CartDto
    {
        $catItemDto = [];
        foreach ($cartItems as $item) {
            $catItemDto[] = new CartItemDto(
                $item['product_code'],
                (float) $item['price'],
                (int) $item['quantity'],
            );
        }
        
        return new CartDto(
            $cartId,
            $catItemDto
        );
    }
}
