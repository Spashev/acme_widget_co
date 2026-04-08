<?php

declare(strict_types=1);

namespace App\Repositories;

use PDO;
use PDOStatement;

readonly class ProductRepository
{
    public function __construct(private PDO $pdo) {}
    
    public function getAllProducts(): array
    {
        /** @var PDOStatement $stmt */
        $stmt = $this->pdo->query('SELECT code, price FROM products');
        
        $products = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $products[$row['code']] = (float) $row['price'];
        }

        return $products;
    }
}
