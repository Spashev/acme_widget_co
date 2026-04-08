<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Database;
use App\Repositories\CartRepository;
use App\Repositories\ProductRepository;
use App\Services\CartService;
use App\Services\ProductService;
use App\Traits\JsonResponse;
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

    public function addItem(int $cartId = 0)
    {
        $input = json_decode(file_get_contents('php://input'), true) ?? [];

        $productCode = $input['product_code'] ?? null;
        $quantity = $input['quantity'] ?? 1;

        if (empty($productCode) || !is_string($productCode)) {
            $this->error("product_code is required", 422);
            return;
        }

        $catalogue = $this->productService->getProducts();
        
        if (!isset($catalogue[$productCode])) {
            $this->error("Product '$productCode' not found", 422);
            return;
        }

        if (!is_int($quantity) || $quantity < 1) {
            $this->error('quantity must be a positive integer', 422);
            return;
        }

        try {
            $cart = $this->cartService->addItem($cartId, $productCode, $quantity);
            $this->json(['message' => 'Product added', 'cart' => $cart], 201);
            return;
        } catch (RuntimeException $e) {
            $this->error($e->getMessage(), $e->getCode());
        }
    }
}
