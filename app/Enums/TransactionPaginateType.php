<?php

declare(strict_types=1);

namespace App\Enums;

enum TransactionPaginateType
{
    case ALL;
    case PENDING;
    case GROUPED;
}