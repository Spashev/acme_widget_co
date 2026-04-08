<?php

declare(strict_types=1);

namespace App\Repositories;

use PDO;
use PDOStatement;

readonly class CartRepository
{
    public function __construct(private PDO $pdo) {}

    public function exists(int $cartId): bool
    {
        /** @var PDOStatement $stmt */
        $stmt = $this->pdo->prepare('SELECT 1 FROM carts WHERE id = :id');
        $stmt->execute(['id' => $cartId]);

        return (bool) $stmt->fetch();
    }

    public function create(): int
    {
        $this->pdo->prepare('INSERT INTO carts () VALUES ()')->execute();

        return (int) $this->pdo->lastInsertId();
    }
    
    public function addItem(int $cartId, string $productCode, int $quantity): void
    {
        /** @var PDOStatement $stmt */
        $stmt = $this->pdo->prepare(
            'INSERT INTO cart_items (cart_id, product_code, quantity)
             VALUES (:cart_id, :product_code, :quantity)
             ON DUPLICATE KEY UPDATE quantity = quantity + :add_quantity'
        );

        $stmt->execute([
            'cart_id' => $cartId,
            'product_code' => $productCode,
            'quantity' => $quantity,
            'add_quantity' => $quantity,
        ]);
    }

    public function findWithItems(int $cartId): array
    {
        /** @var PDOStatement $stmt */
        $stmt = $this->pdo->prepare(
            'SELECT ci.product_code, ci.quantity, p.price
             FROM cart_items ci
             JOIN products p ON p.code = ci.product_code
             WHERE ci.cart_id = :cart_id'
        );
        $stmt->execute(['cart_id' => $cartId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
