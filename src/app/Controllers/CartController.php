<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Database;
use App\Repositories\CartRepository;
use App\Repositories\ProductRepository;
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
        $pdo = Database::getInstance()->getConnection();

        $this->cartService = new CartService(
            new CartRepository($pdo)
        );
        $this->productService = new ProductService(
          new ProductRepository($pdo)  
        );
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
        echo $cartId;
    }

    public function deleteCart(int $cartId = 0): void
    {
        echo $cartId;
    }
}
