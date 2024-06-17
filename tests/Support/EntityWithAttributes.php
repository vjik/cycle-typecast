<?php

declare(strict_types=1);

namespace Vjik\CycleTypecast\Tests\Support;

use Vjik\CycleTypecast\ArrayToStringType;
use Vjik\CycleTypecast\UuidString\UuidStringToBytesType;

final class EntityWithAttributes
{
    #[UuidStringToBytesType]
    public string $id;

    #[ArrayToStringType(',')]
    public array $names;

    public int $age;
}
