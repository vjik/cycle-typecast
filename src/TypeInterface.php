<?php

declare(strict_types=1);

namespace Vjik\CycleTypecast;

interface TypeInterface
{
    public function convertToDatabaseValue(mixed $value): mixed;

    public function convertToPhpValue(mixed $value): mixed;
}
