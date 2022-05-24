<?php

declare(strict_types=1);

namespace Vjik\CycleTypecast\UuidString;

use Exception;
use InvalidArgumentException;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Vjik\CycleTypecast\TypeInterface;

abstract class UuidStringType implements TypeInterface
{
    public function convertToDatabaseValue(mixed $value): mixed
    {
        if ($value === null) {
            return null;
        }

        if (!is_string($value)) {
            throw new InvalidArgumentException('Incorrect value.');
        }

        try {
            $uuid = Uuid::fromString($value);
        } catch (Exception $e) {
            throw new InvalidArgumentException();
        }

        return $this->toDatabaseValue($uuid);
    }

    abstract protected function toDatabaseValue(UuidInterface $value): mixed;

    public function convertToPhpValue(mixed $value): mixed
    {
        if ($value === null) {
            return null;
        }

        return $this->toPhpValue($value);
    }

    abstract protected function toPhpValue(mixed $value): string;
}
