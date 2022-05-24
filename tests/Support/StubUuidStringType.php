<?php

declare(strict_types=1);

namespace Vjik\CycleTypecast\Tests\Support;

use Ramsey\Uuid\UuidInterface;
use Vjik\CycleTypecast\UuidString\UuidStringType;

final class StubUuidStringType extends UuidStringType
{
    protected function toDatabaseValue(UuidInterface $value): mixed
    {
        return $value->toString();
    }

    protected function toPhpValue(mixed $value): string
    {
        return $value;
    }
}
