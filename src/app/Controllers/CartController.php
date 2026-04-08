<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Factory\CartServiceFactory;
use App\Factory\ProductServiceFactory;
use App\Services\CartService;
use App\Services\ProductService;
use App\Requests\AddToCartRequest;
use App\Traits\JsonResponse;
use JsonException;
use RuntimeException;

class CartController
{
    use JsonResponse;

    private CartService $cartService;
    private ProductService $productService;

    public function __construct()
    {
        $this->cartService = CartServiceFactory::create();
        $this->productService = ProductServiceFactory::create();
    }

    public function addItem(int $cartId = 0): void
    {
        $catalogue = $this->productService->getProducts();
        
        $request = new AddToCartRequest($catalogue);

        if (!$request->isValid()) {
            $this->error(implode(', ', $request->getErrors()), 422);
            return;
        }

        try {
            $cart = $this->cartService->addItem($cartId, $request->productCode, $request->quantity);
            $this->json(
                [
                    'message' => 'Product added',
                    'cart' => $cart->toArray()
                ],
                201
            );
        } catch (JsonException|RuntimeException $e) {
            $this->error($e->getMessage(), $e->getCode());
        }
    }
    
    public function getCartTotal(int $cartId = 0): void
    {
        try {
            $this->json($this->cartService->getTotal($cartId));
        } catch (JsonException|RuntimeException $e) {
            $this->error($e->getMessage(), $e->getCode());
        }
    }

    public function deleteCart(int $cartId = 0): void
    {
        try {
            $this->cartService->deleteCart($cartId);
            $this->json(['message' => 'Cart deleted'], 204);
        } catch (JsonException|RuntimeException $e) {
            $this->error($e->getMessage(), $e->getCode());
        }
    }
}
