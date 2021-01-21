<?php

declare(strict_types=1);

namespace Vjik\CycleTypecast\DateTimeImmutable;

use DateTimeImmutable;
use InvalidArgumentException;
use Vjik\CycleTypecast\TypeInterface;

abstract class DateTimeImmutableType implements TypeInterface
{
    public function convertToDatabaseValue($value)
    {
        if ($value === null) {
            return null;
        }

        if (!($value instanceof DateTimeImmutable)) {
            throw new InvalidArgumentException('Incorrect value.');
        }

        return $this->toDatabaseValue($value);
    }

    /**
     * @param DateTimeImmutable $value
     *
     * @return mixed
     */
    abstract protected function toDatabaseValue(DateTimeImmutable $value);

    public function convertToPhpValue($value)
    {
        if ($value === null) {
            return null;
        }

        return $this->toPhpValue($value);
    }

    /**
     * @param mixed $value
     *
     * @return DateTimeImmutable
     */
    abstract protected function toPhpValue($value): DateTimeImmutable;
}
