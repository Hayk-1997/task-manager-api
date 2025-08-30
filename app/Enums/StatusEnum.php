<?php

namespace App\Enums;

enum StatusEnum: string
{
    case PENDING = 'pending';
    case CANCELLED = 'cancelled';
    case IN_PROGRESS = 'in_progress';
    case COMPLETED = 'completed';
}
