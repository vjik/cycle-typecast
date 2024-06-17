<?php

declare(strict_types=1);

namespace Vjik\CycleTypecast\Tests\Support;

use Attribute;
use Ramsey\Uuid\UuidInterface;
use Vjik\CycleTypecast\UuidString\UuidStringType;

#[Attribute(Attribute::TARGET_PROPERTY)]
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
