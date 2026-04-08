<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\CartRepository;

readonly class CartService
{
    public function __construct(
        private CartRepository $cartRepository
    ) {}
    
    public function addItem(int $cartId, string $productCode, int $quantity): array
    {
        if (!$this->cartRepository->exists($cartId)) {
            $cartId = $this->cartRepository->create();
        }
        
        $this->cartRepository->addItem($cartId, $productCode, $quantity);

        return $this->cartRepository->findWithItems($cartId);
    }
}
