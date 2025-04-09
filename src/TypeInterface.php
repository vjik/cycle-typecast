<?php

declare(strict_types=1);

namespace Vjik\CycleTypecast;

interface TypeInterface
{
    public function convertToDatabaseValue(mixed $value, UncastContext $context): mixed;

    public function convertToPhpValue(mixed $value, CastContext $context): mixed;
}
