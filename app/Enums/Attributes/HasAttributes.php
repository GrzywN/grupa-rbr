<?php

namespace App\Enums\Attributes;

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

    /**
     * @return string[]
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
