<?php

declare(strict_types=1);

namespace App\Enums;

enum DeliveryRuleEnum: string
{
    case Standard = 'standard';
    case Reduced = 'reduced';
    case Free = 'free';
}
