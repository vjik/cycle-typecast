<?php

declare(strict_types=1);

namespace Vjik\CycleTypecast\DateTimeImmutable;

use DateTimeImmutable;
use InvalidArgumentException;

use function is_int;
use function is_string;

final class DateTimeImmutableToIntegerType extends DateTimeImmutableType
{
    protected function toDatabaseValue(DateTimeImmutable $value): string
    {
        return (string)$value->getTimestamp();
    }

    protected function toPhpValue($value): DateTimeImmutable
    {
        if (!is_string($value) && !is_int($value)) {
            throw new InvalidArgumentException('Incorrect value.');
        }

        return (new DateTimeImmutable())->setTimestamp((int)$value);
    }
}
