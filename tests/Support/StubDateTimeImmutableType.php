<?php

declare(strict_types=1);

namespace Vjik\CycleTypecast\Tests\Support;

use Attribute;
use DateTimeImmutable;
use Vjik\CycleTypecast\DateTimeImmutable\DateTimeImmutableType;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class StubDateTimeImmutableType extends DateTimeImmutableType
{
    protected function toDatabaseValue(DateTimeImmutable $value): mixed
    {
        return $value->getTimestamp();
    }

    protected function toPhpValue($value): DateTimeImmutable
    {
        return (new DateTimeImmutable())->setTimestamp($value);
    }
}
