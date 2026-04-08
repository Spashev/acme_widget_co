<?php

declare(strict_types=1);

namespace App\Rules;

interface RuleInterface
{
    /**
     * @param array<string, int> $items product_code => quantity
     * @param array<string, float> $prices product_code => price
     */
    public function apply(array $items, array $prices): float;
}
