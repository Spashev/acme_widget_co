<?php

declare(strict_types=1);

namespace App\Factory;


use App\Core\Database;
use App\Repositories\ProductRepository;
use App\Services\ProductService;

class ProductServiceFactory
{
    public static function create(): ProductService
    {
        $pdo = Database::getInstance()->getConnection();

        return new ProductService(
            new ProductRepository($pdo)
        );
    }
}
