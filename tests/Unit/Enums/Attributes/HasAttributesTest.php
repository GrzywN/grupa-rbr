<?php

namespace Tests\Unit\Enums\Attributes;

use App\Enums\Attributes\Description;
use App\Enums\Attributes\HasAttributes;
use App\Enums\Attributes\Severity;
use App\Enums\TagSeverity;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

enum AttributeExample: string
{
    use HasAttributes;

    #[Description('FIRST_DESCRIPTION')]
    #[Severity(TagSeverity::SUCCESS)]
    case FIRST = 'FIRST';

    #[Description('SECOND_DESCRIPTION')]
    #[Severity(TagSeverity::DANGER)]
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
    public function it_can_get_severity(): void
    {
        $this->assertEquals(
            TagSeverity::SUCCESS->value,
            AttributeExample::FIRST->severity()
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

    #[Test]
    public function it_can_get_option_to_array(): void
    {
        $this->assertEquals(
            ['value' => 'FIRST', 'label' => 'FIRST_DESCRIPTION', 'severity' => TagSeverity::SUCCESS->value],
            AttributeExample::FIRST->toArray()
        );
    }

    #[Test]
    public function it_can_get_options_array(): void
    {
        $this->assertEquals(
            [
                ['value' => 'FIRST', 'label' => 'FIRST_DESCRIPTION', 'severity' => TagSeverity::SUCCESS->value],
                ['value' => 'SECOND', 'label' => 'SECOND_DESCRIPTION', 'severity' => TagSeverity::DANGER->value],
            ],
            AttributeExample::toOptionsArray()
        );
    }
}
