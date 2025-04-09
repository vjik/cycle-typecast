<?php

declare(strict_types=1);

namespace Vjik\CycleTypecast;

final class UncastContext
{
    public function __construct(
        public readonly string $property,
        public readonly array $data,
    ) {}
}
