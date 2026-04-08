<?php

declare(strict_types=1);

namespace App\Dto;

readonly class CartItemDto
{
    public function __construct(
        public string $productCode,
        public float  $price,
        public int    $quantity,
    ) {}
}
