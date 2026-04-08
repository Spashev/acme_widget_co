<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Database;
use App\Repositories\ProductRepository;
use App\Services\ProductService;
use App\Traits\JsonResponse;
use JsonException;
use RuntimeException;

class IndexController
{
    use JsonResponse;
    
    private ProductService $productService;
    
    public function __construct()
    {
        $pdo = Database::getInstance()->getConnection();
        
        $this->productService = new ProductService(
            new ProductRepository($pdo)
        );
    }

    public function home(): void
    {
        try {
            $products = $this->productService->getProducts();
            
            $this->json(['products' => $products], 201);
        } catch (JsonException|RuntimeException $e) {
            $this->error($e->getMessage(), $e->getCode());
        }
    }
}
