<?php

declare(strict_types=1);

namespace Vjik\CycleTypecast;

use InvalidArgumentException;

final class ArrayType implements TypeInterface
{
    private string $delimiter;

    public function __construct(string $delimiter)
    {
        $this->delimiter = $delimiter;
    }

    public function convertToDatabaseValue($value): string
    {
        if (!is_array($value)) {
            throw new InvalidArgumentException('Incorrect value.');
        }

        return implode($this->delimiter, $value);
    }

    public function convertToPhpValue($value)
    {
        if (!is_string($value)) {
            throw new InvalidArgumentException('Incorrect value.');
        }

        if ($value === '') {
            return [];
        }

        return explode($this->delimiter, $value);
    }
}
