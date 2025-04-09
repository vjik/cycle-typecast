<?php

declare(strict_types=1);

namespace Vjik\CycleTypecast\Tests\Support;

use Vjik\CycleTypecast\CastContext;
use Vjik\CycleTypecast\TypeInterface;
use Vjik\CycleTypecast\UncastContext;

final class StubType implements TypeInterface
{
    private mixed $toDatabaseValue = null;
    private ?UncastContext $uncastContext = null;

    private mixed $toPhpValue = null;
    private ?CastContext $castContext = null;

    public function convertToDatabaseValue(mixed $value, UncastContext $context): mixed
    {
        $this->toDatabaseValue = $value;
        $this->uncastContext = $context;
        return $value;
    }

    public function convertToPhpValue(mixed $value, CastContext $context): mixed
    {
        $this->toPhpValue = $value;
        $this->castContext = $context;
        return $value;
    }

    public function getToDatabaseValue(): mixed
    {
        return $this->toDatabaseValue;
    }

    public function getUncastContext(): ?UncastContext
    {
        return $this->uncastContext;
    }

    public function getToPhpValue(): mixed
    {
        return $this->toPhpValue;
    }

    public function getCastContext(): ?CastContext
    {
        return $this->castContext;
    }
}
