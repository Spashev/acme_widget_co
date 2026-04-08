<?php

declare(strict_types=1);

namespace App\Factory;


use App\Core\Database;
use App\Repositories\CartRepository;
use App\Repositories\ProductRepository;
use App\Rules\DiscountRule;
use App\Services\CartService;

class CartServiceFactory
{
    public static function create(): CartService
    {
        $pdo = Database::getInstance()->getConnection();

        return new CartService(
            new CartRepository($pdo),
            new ProductRepository($pdo),
            [
                new DiscountRule(),
            ]
        );
    }
}
