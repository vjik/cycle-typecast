<?php

declare(strict_types=1);

namespace Vjik\CycleTypecast;

use DateTimeImmutable;
use InvalidArgumentException;
use RuntimeException;

final class DateTimeImmutableType implements TypeInterface
{
    public const INTEGER = 'integer';

    private string $databaseType;

    public function __construct(string $databaseType)
    {
        $this->setDatabaseType($databaseType);
    }

    private function setDatabaseType(string $databaseType): void
    {
        if (!in_array($databaseType, [self::INTEGER])) {
            throw new InvalidArgumentException('Incorrect database type.');
        }

        $this->databaseType = $databaseType;
    }

    public function convertToDatabaseValue($value)
    {
        if ($value === null) {
            return null;
        }

        if (!($value instanceof DateTimeImmutable)) {
            throw new InvalidArgumentException('Incorrect value.');
        }

        switch ($this->databaseType) {
            case self::INTEGER:
                return (string)$value->getTimestamp();

            default:
                throw new RuntimeException();
        }
    }

    public function convertToPhpValue($value)
    {
        if ($value === null) {
            return null;
        }

        if (!is_string($value)) {
            throw new InvalidArgumentException('Incorrect value.');
        }

        switch ($this->databaseType) {
            case self::INTEGER:
                return (new DateTimeImmutable())->setTimestamp((int)$value);

            default:
                throw new RuntimeException();
        }
    }
}
