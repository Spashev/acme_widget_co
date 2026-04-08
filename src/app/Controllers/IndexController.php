<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Database;
use App\Repositories\ProductRepository;
use App\Services\ProductService;

class IndexController
{
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
        $products = $this->productService->getProducts();
        
        print_r($products);
    }
}
