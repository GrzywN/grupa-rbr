<?php

namespace App\Enums;

use App\Enums\Attributes\Description;
use App\Enums\Attributes\HasAttributes;
use App\Enums\Attributes\Severity;

enum TaskHistoryEvent: string
{
    use HasAttributes;

    #[Description('Created')]
    #[Severity(TagSeverity::SUCCESS)]
    case CREATED = 'created';

    #[Description('Updated')]
    #[Severity(TagSeverity::INFO)]
    case UPDATED = 'updated';

    #[Description('Deleted')]
    #[Severity(TagSeverity::DANGER)]
    case DELETED = 'deleted';
}
