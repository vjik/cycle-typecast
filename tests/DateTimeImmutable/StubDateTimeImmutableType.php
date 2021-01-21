<?php

declare(strict_types=1);

namespace Vjik\CycleTypecast\Tests\DateTimeImmutable;

use DateTimeImmutable;
use Vjik\CycleTypecast\DateTimeImmutable\DateTimeImmutableType;

final class StubDateTimeImmutableType extends DateTimeImmutableType
{
    protected function toDatabaseValue(DateTimeImmutable $value)
    {
        return $value->getTimestamp();
    }

    protected function toPhpValue($value): DateTimeImmutable
    {
        return (new DateTimeImmutable())->setTimestamp($value);
    }
}
