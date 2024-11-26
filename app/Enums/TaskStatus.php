<?php

namespace App\Enums;

use App\Enums\Attributes\Description;
use App\Enums\Attributes\HasAttributes;
use App\Enums\Attributes\Severity;

enum TaskStatus: string
{
    use HasAttributes;

    #[Description('To-do')]
    #[Severity(TagSeverity::INFO)]
    case TO_DO = 'TO_DO';

    #[Description('In progress')]
    #[Severity(TagSeverity::WARN)]
    case IN_PROGRESS = 'IN_PROGRESS';

    #[Description('Done')]
    #[Severity(TagSeverity::SUCCESS)]
    case DONE = 'DONE';
}
