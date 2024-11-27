<?php

namespace Tests;

use Carbon\Carbon;
use Exception;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    public function assertIsIso8601(mixed $date): void
    {
        try {
            $isIso8601 = Carbon::parse($date)->toIso8601String() === $date;
        } catch (Exception) {
            $isIso8601 = false;
        }

        $this->assertTrue($isIso8601);
    }
}
