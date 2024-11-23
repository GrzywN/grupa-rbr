<?php

namespace App\Helpers;

use AssertionError;
use Log;

class Assert
{
    /**
     * Asserts that a condition is true
     *
     * @param  bool  $condition  The condition to check
     * @param  string  $message  Optional error message
     *
     * @throws AssertionError When the condition is false
     */
    public static function that(bool $condition, string $message = 'Assertion failed'): void
    {
        if (! $condition) {
            Log::critical($message);
            throw new AssertionError($message);
        }
    }
}
