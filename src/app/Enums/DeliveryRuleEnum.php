<?php

declare(strict_types=1);

namespace App\Enums;

enum DeliveryRuleEnum: string
{
    case Standard = 'standard';
    case Reduced = 'reduced';
    case Free = 'free';

    public function cost(): float
    {
        return match ($this) {
            self::Standard => 4.95,
            self::Reduced => 2.95,
            self::Free => 0.00,
        };
    }

    public function maxTotal(): float
    {
        return match ($this) {
            self::Standard => 50.00,
            self::Reduced => 90.00,
            self::Free => PHP_FLOAT_MAX,
        };
    }

    public static function resolve(float $total): self
    {
        foreach (self::cases() as $case) {
            if ($total < $case->maxTotal()) {
                return $case;
            }
        }

        return self::Free;
    }
}
