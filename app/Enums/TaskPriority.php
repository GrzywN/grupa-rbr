<?php

namespace App\Enums;

use App\Enums\Attributes\Description;
use App\Enums\Attributes\HasAttributes;
use App\Enums\Attributes\Severity;

enum TaskPriority: string
{
    use HasAttributes;

    #[Description('Low')]
    #[Severity(TagSeverity::INFO)]
    case LOW = 'LOW';

    #[Description('Medium')]
    #[Severity(TagSeverity::WARN)]
    case MEDIUM = 'MEDIUM';

    #[Description('High')]
    #[Severity(TagSeverity::DANGER)]
    case HIGH = 'HIGH';
}
