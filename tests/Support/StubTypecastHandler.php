<?php

declare(strict_types=1);

namespace Vjik\CycleTypecast\Tests\Support;

use Vjik\CycleTypecast\ArrayToStringType;
use Vjik\CycleTypecast\TypecastHandler;

final class StubTypecastHandler extends TypecastHandler
{
    protected function getConfig(): array
    {
        return [
            'letters' => new ArrayToStringType(','),
        ];
    }
}
