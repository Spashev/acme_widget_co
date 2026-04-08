<?php

declare(strict_types=1);

namespace App\Rules;

use App\Enums\DeliveryRuleEnum;

class DeliveryRule
{
    public static function maxTotal(DeliveryRuleEnum $rule): float
    {
        return match ($rule) {
            DeliveryRuleEnum::Standard => 50.00,
            DeliveryRuleEnum::Reduced => 90.00,
            DeliveryRuleEnum::Free => PHP_FLOAT_MAX,
        };
    }

    public static function cost(DeliveryRuleEnum $rule): float
    {
        return match ($rule) {
            DeliveryRuleEnum::Standard => 4.95,
            DeliveryRuleEnum::Reduced => 2.95,
            DeliveryRuleEnum::Free => 0.00,
        };
    }

    public static function resolve(float $total): DeliveryRuleEnum
    {
        foreach (DeliveryRuleEnum::cases() as $rule) {
            if ($total < self::maxTotal($rule)) {
                return $rule;
            }
        }

        return DeliveryRuleEnum::Free;
    }
}
