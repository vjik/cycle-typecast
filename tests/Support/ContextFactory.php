<?php

declare(strict_types=1);

namespace Vjik\CycleTypecast\Tests\Support;

use Vjik\CycleTypecast\CastContext;
use Vjik\CycleTypecast\UncastContext;

final class ContextFactory
{
    public static function castContext(): CastContext
    {
        return new CastContext('key', []);
    }

    public static function uncastContext(): UncastContext
    {
        return new UncastContext('key', []);
    }
}
