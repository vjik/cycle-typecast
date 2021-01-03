<?php

declare(strict_types=1);

namespace Vjik\CycleTypecast;

use Exception;
use InvalidArgumentException;
use Ramsey\Uuid\Uuid;
use RuntimeException;

final class UuidType implements TypeInterface
{
    public const BYTES = 'bytes';

    private string $databaseType;

    public function __construct(string $databaseType)
    {
        $this->setDatabaseType($databaseType);
    }

    private function setDatabaseType(string $databaseType): void
    {
        if (!in_array($databaseType, [self::BYTES])) {
            throw new InvalidArgumentException('Incorrect database type.');
        }

        $this->databaseType = $databaseType;
    }

    public function convertToDatabaseValue($value)
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

        switch ($this->databaseType) {
            case self::BYTES:
                return $uuid->getBytes();

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
