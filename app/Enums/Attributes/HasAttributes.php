<?php

namespace App\Enums\Attributes;

use App\Enums\TagSeverity;
use Illuminate\Support\Str;
use ReflectionClassConstant;

trait HasAttributes
{
    public function description(): string
    {
        $ref = new ReflectionClassConstant(self::class, $this->name);
        $classAttributes = $ref->getAttributes(Description::class);

        if (count($classAttributes) === 0) {
            return Str::headline($this->value);
        }

        return $classAttributes[0]->newInstance()->description;
    }

    public function severity(): string
    {
        $ref = new ReflectionClassConstant(self::class, $this->name);
        $classAttributes = $ref->getAttributes(Severity::class);

        if (count($classAttributes) === 0) {
            return TagSeverity::INFO->value;
        }

        return $classAttributes[0]->newInstance()->severity->value;
    }

    /**
     * @return string[]
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * @return array{'value': string, 'label': string, 'severity': string}
     */
    public function toArray(): array
    {
        return [
            'value' => $this->value,
            'label' => $this->description(),
            'severity' => $this->severity(),
        ];
    }

    /**
     * @return array{'value': string, 'label': string, 'severity': string}[]
     */
    public static function toOptionsArray(): array
    {
        return array_map(static fn (self $enum): array => $enum->toArray(), self::cases());
    }
}
