<?php

declare(strict_types=1);

namespace Vjik\CycleColumns;

use InvalidArgumentException;

final class ArrayColumn implements ColumnInterface
{
    private string $delimiter;

    public function __construct(string $delimiter)
    {
        $this->delimiter = $delimiter;
    }

    public function afterExtract($value): string
    {
        if (!is_array($value)) {
            throw new InvalidArgumentException('Incorrect value.');
        }

        return implode($this->delimiter, $value);
    }

    public function beforeHydrate(string $value)
    {
        if ($value === '') {
            return [];
        }

        return explode($this->delimiter, $value);
    }
}
