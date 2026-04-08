<?php

declare(strict_types=1);

namespace App\Repositories;

use PDO;

readonly class ProductRepository
{
    public function __construct(private PDO $pdo) {}
    
    public function getAllProducts(): array
    {
        $stmt = $this->pdo->query('SELECT code, price FROM products');
        $catalogue = [];

        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $catalogue[$row['code']] = (float) $row['price'];
        }

        return $catalogue;
    }
}
