<?php

declare(strict_types=1);

namespace Vjik\CycleTypecast;

final class CastContext
{
    public function __construct(
        public readonly string $property,
        public readonly array $data,
    ) {}
}
