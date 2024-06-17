<?php

declare(strict_types=1);

namespace Vjik\CycleTypecast\UuidString;

use Attribute;
use Exception;
use InvalidArgumentException;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class UuidStringToBytesType extends UuidStringType
{
    protected function toDatabaseValue(UuidInterface $value): string
    {
        return $value->getBytes();
    }

    protected function toPhpValue(mixed $value): string
    {
        if (!is_string($value)) {
            throw new InvalidArgumentException('Incorrect value.');
        }

        try {
            $uuid = Uuid::fromBytes($value);
        } catch (Exception $e) {
            throw new InvalidArgumentException();
        }

        return $uuid->toString();
    }
}
