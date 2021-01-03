<?php

declare(strict_types=1);

namespace Vjik\CycleColumns;

use Exception;
use InvalidArgumentException;
use Ramsey\Uuid\Uuid;
use RuntimeException;

final class UuidColumn implements ColumnInterface
{
    public const BYTES = 'bytes';

    private string $columnType;

    public function __construct(string $columnType)
    {
        $this->setColumnType($columnType);
    }

    private function setColumnType(string $columnType): void
    {
        if (!in_array($columnType, [self::BYTES])) {
            throw new InvalidArgumentException('Incorrect column type.');
        }

        $this->columnType = $columnType;
    }

    public function afterExtract($value): string
    {
        if (!is_string($value)) {
            throw new InvalidArgumentException('Incorrect value.');
        }

        try {
            $uuid = Uuid::fromString($value);
        } catch (Exception $e) {
            throw new InvalidArgumentException();
        }

        switch ($this->columnType) {
            case self::BYTES:
                return $uuid->getBytes();

            default:
                throw new RuntimeException();
        }
    }

    public function beforeHydrate(string $value)
    {
        switch ($this->columnType) {
            case self::BYTES:
                try {
                    $uuid = Uuid::fromBytes($value);
                } catch (Exception $e) {
                    throw new InvalidArgumentException();
                }
                return $uuid->toString();

            default:
                throw new RuntimeException();
        }
    }
}
