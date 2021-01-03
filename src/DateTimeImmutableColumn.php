<?php

declare(strict_types=1);

namespace Vjik\CycleColumns;

use DateTimeImmutable;
use InvalidArgumentException;
use RuntimeException;

final class DateTimeImmutableColumn implements ColumnInterface
{
    public const INTEGER = 'integer';

    private string $columnType;

    public function __construct(string $columnType)
    {
        $this->setColumnType($columnType);
    }

    private function setColumnType(string $columnType): void
    {
        if (!in_array($columnType, [self::INTEGER])) {
            throw new InvalidArgumentException('Incorrect column type.');
        }

        $this->columnType = $columnType;
    }

    public function afterExtract($value): string
    {
        if (!($value instanceof DateTimeImmutable)) {
            throw new InvalidArgumentException('Incorrect value.');
        }

        switch ($this->columnType) {
            case self::INTEGER:
                return (string)$value->getTimestamp();

            default:
                throw new RuntimeException();
        }
    }

    public function beforeHydrate(string $value)
    {
        switch ($this->columnType) {
            case self::INTEGER:
                return (new DateTimeImmutable())->setTimestamp((int)$value);

            default:
                throw new RuntimeException();
        }
    }
}
