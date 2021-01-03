<?php

declare(strict_types=1);

namespace Vjik\CycleTypecast\Tests;

use DateTimeImmutable;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use RuntimeException;
use Vjik\CycleTypecast\DateTimeImmutableType;

final class DateTimeImmutableTypeTest extends TestCase
{
    public function testBase(): void
    {
        $timestamp = 1609658768;

        $databaseValue = (string)$timestamp;
        $entityValue = (new DateTimeImmutable())->setTimestamp($timestamp);

        $type = new DateTimeImmutableType(DateTimeImmutableType::INTEGER);

        $value = $type->convertToDatabaseValue($entityValue);
        $this->assertSame($databaseValue, $value);

        $value = $type->convertToPhpValue($databaseValue);
        $this->assertInstanceOf(DateTimeImmutable::class, $value);
        $this->assertSame($timestamp, $value->getTimestamp());
    }

    public function testIncorrectDatabaseType(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new DateTimeImmutableType('unknown');
    }

    public function testConvertToDatabaseValueIncorrectValue(): void
    {
        $type = new DateTimeImmutableType(DateTimeImmutableType::INTEGER);

        $this->expectException(InvalidArgumentException::class);
        $type->convertToDatabaseValue(42);
    }

    public function testConvertToDatabaseValueWithIncorrectDatabaseType(): void
    {
        $property = (new ReflectionClass(DateTimeImmutableType::class))->getProperty('databaseType');
        $property->setAccessible(true);

        $type = new DateTimeImmutableType(DateTimeImmutableType::INTEGER);
        $property->setValue($type, 'incorrect');

        $this->expectException(RuntimeException::class);
        $type->convertToDatabaseValue(new DateTimeImmutable());
    }

    public function testConertToPhpValueWithIncorrectDatabaseType(): void
    {
        $property = (new ReflectionClass(DateTimeImmutableType::class))->getProperty('databaseType');
        $property->setAccessible(true);

        $type = new DateTimeImmutableType(DateTimeImmutableType::INTEGER);
        $property->setValue($type, 'incorrect');

        $this->expectException(RuntimeException::class);
        $type->convertToPhpValue('1609658768');
    }

    public function testConertToPhpValueWithIntegerValue(): void
    {
        $type = new DateTimeImmutableType(DateTimeImmutableType::INTEGER);

        $this->expectException(InvalidArgumentException::class);
        $type->convertToPhpValue(42);
    }
}
