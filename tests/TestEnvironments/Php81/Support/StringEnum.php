<?php

declare(strict_types=1);

namespace Vjik\CycleTypecast\Tests\TestEnvironments\Php81\Support;

enum StringEnum: string
{
    case A = 'a';
    case B = 'b';
}
