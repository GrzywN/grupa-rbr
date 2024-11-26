<?php

namespace App\Enums\Attributes;

use App\Enums\TagSeverity;
use Attribute;

#[Attribute]
class Severity
{
    public function __construct(
        public TagSeverity $severity,
    ) {
    }
}
