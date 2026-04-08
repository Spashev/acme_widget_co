<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\ProductRepository;

readonly class ProductService
{
    public function __construct(
        private ProductRepository $productRepository
    ) {}
    
    public function getProducts(): array
    {
        return $this->productRepository->getAllProducts();
    }
}
