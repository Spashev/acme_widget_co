<?php

declare(strict_types=1);

namespace App\Repositories;

use PDO;

readonly class ProductRepository
{
    public function __construct(private PDO $pdo) {}
    
    public function getAllProducts(): array
    {
        $stmt = $this->pdo->query('SELECT code, name, price FROM products');

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
