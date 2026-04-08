<?php

declare(strict_types=1);

namespace App\Dto;

readonly class CartDto
{
    /**
     * @param CartItemDto[] $items
     */
    public function __construct(
        public int   $id,
        public array $items = [],
    ) {}

    public function toArray(): array
    {
        return [
            'cart_id' => $this->id,
            'items' => array_map(fn(CartItemDto $item) => [
                'product_code' => $item->productCode,
                'price' => $item->price,
                'quantity' => $item->quantity,
            ], $this->items),
        ];
    }
}
