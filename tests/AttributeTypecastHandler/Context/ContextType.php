<?php

declare(strict_types=1);

namespace Vjik\CycleTypecast\Tests\AttributeTypecastHandler\Context;

use Attribute;
use Vjik\CycleTypecast\CastContext;
use Vjik\CycleTypecast\TypeInterface;
use Vjik\CycleTypecast\UncastContext;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class ContextType implements TypeInterface
{
    public function convertToDatabaseValue(mixed $value, UncastContext $context): mixed
    {
        return $context;
    }

    public function convertToPhpValue(mixed $value, CastContext $context): mixed
    {
        return $context;
    }
}
