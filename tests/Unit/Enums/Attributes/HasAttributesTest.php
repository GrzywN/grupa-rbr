<?php

namespace Tests\Unit\Enums\Attributes;

use App\Enums\Attributes\Description;
use App\Enums\Attributes\HasAttributes;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

enum AttributeExample: string
{
    use HasAttributes;

    #[Description('FIRST_DESCRIPTION')]
    case FIRST = 'FIRST';

    #[Description('SECOND_DESCRIPTION')]
    case SECOND = 'SECOND';
}

class HasAttributesTest extends TestCase
{
    #[Test]
    public function it_can_get_description(): void
    {
        $this->assertEquals(
            'FIRST_DESCRIPTION',
            AttributeExample::FIRST->description()
        );
    }

    #[Test]
    public function it_can_get_values(): void
    {
        $this->assertEquals(
            ['FIRST', 'SECOND'],
            AttributeExample::values()
        );
    }
}
