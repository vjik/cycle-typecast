<?php

declare(strict_types=1);

namespace Vjik\CycleTypecast\Tests\UuidString;

use Ramsey\Uuid\UuidInterface;
use Vjik\CycleTypecast\UuidString\UuidStringType;

final class StubUuidStringType extends UuidStringType
{
    protected function toDatabaseValue(UuidInterface $value)
    {
        return $value->toString();
    }

    protected function toPhpValue($value): string
    {
        return $value;
    }
}
