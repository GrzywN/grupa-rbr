<?php

namespace App\Enums;

enum TagSeverity: string
{
    case SUCCESS = 'success';
    case INFO = 'info';
    case WARN = 'warn';
    case DANGER = 'danger';
}
