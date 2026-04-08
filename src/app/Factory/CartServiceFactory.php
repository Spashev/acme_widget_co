<?php

declare(strict_types=1);

namespace App\Factory;

use App\Core\Database;
use App\Repositories\CartRepository;
use App\Repositories\ProductRepository;
use App\Rules\DiscountRule;
use App\Services\CartCalculator;
use App\Services\CartService;

class CartServiceFactory
{
    public static function create(): CartService
    {
        $pdo = Database::getInstance()->getConnection();
        $productRepository = new ProductRepository($pdo);

        $calculator = new CartCalculator(
            [new DiscountRule()],
            $productRepository->getAllProducts(),
        );

        return new CartService(
            new CartRepository($pdo),
            $calculator,
        );
    }
}
