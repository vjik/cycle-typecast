<?php

declare(strict_types=1);

namespace Vjik\CycleTypecast\DateTimeImmutable;

use DateTimeImmutable;
use InvalidArgumentException;
use Vjik\CycleTypecast\TypeInterface;

abstract class DateTimeImmutableType implements TypeInterface
{
    public function convertToDatabaseValue(mixed $value): mixed
    {
        if ($value === null) {
            return null;
        }

        if (!($value instanceof DateTimeImmutable)) {
            throw new InvalidArgumentException('Incorrect value.');
        }

        return $this->toDatabaseValue($value);
    }

    abstract protected function toDatabaseValue(DateTimeImmutable $value): mixed;

    public function convertToPhpValue(mixed $value): mixed
    {
        if ($value === null) {
            return null;
        }

        return $this->toPhpValue($value);
    }

    abstract protected function toPhpValue(mixed $value): DateTimeImmutable;
}
