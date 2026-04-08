<?php

declare(strict_types=1);

namespace App\Rules;

/** Buy one red widget, get the second half price */
class DiscountRule implements RuleInterface
{
    private const PRODUCT_CODE = 'R01';

    public function apply(array $items, array $prices): float
    {
        $quantity = $items[self::PRODUCT_CODE] ?? 0;

        if ($quantity < 2) {
            return 0.00;
        }

        $discountedItems = intdiv($quantity, 2);
        $halfPrice = $prices[self::PRODUCT_CODE] / 2;

        return round($discountedItems * $halfPrice, 2);
    }
}
