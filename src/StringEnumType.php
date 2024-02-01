<?php

declare(strict_types=1);

namespace Vjik\CycleTypecast;

use BackedEnum;
use InvalidArgumentException;

final class StringEnumType implements TypeInterface
{
    /**
     * @psalm-param class-string<BackedEnum> $enumClass
     */
    public function __construct(private string $enumClass)
    {
    }

    public function convertToDatabaseValue(mixed $value): mixed
    {
        if ($value === null) {
            return null;
        }

        if (!$value instanceof $this->enumClass) {
            throw new InvalidArgumentException('Incorrect value.');
        }

        return $value->value;
    }

    public function convertToPhpValue(mixed $value): mixed
    {
        if ($value === null) {
            return null;
        }

        if (!is_string($value)) {
            throw new InvalidArgumentException('Incorrect value.');
        }

        return $this->enumClass::from($value);
    }
}
