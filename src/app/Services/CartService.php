<?php

declare(strict_types=1);

namespace App\Services;

use App\Dto\CartDto;
use App\Dto\CartItemDto;
use App\Repositories\CartRepository;

readonly class CartService
{
    public function __construct(
        private CartRepository $cartRepository,
        private CartCalculator $cartCalculator,
    ) {}

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

        $totals = $this->cartCalculator->calculate($dto->items);
        $totals['cart'] = $dto->toArray();

        return $totals;
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
