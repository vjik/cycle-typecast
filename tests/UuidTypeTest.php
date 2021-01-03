<?php

declare(strict_types=1);

namespace Vjik\CycleTypecast\Tests;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use ReflectionClass;
use RuntimeException;
use Vjik\CycleTypecast\UuidType;

final class UuidTypeTest extends TestCase
{
    public function testBase(): void
    {
        $uuid = Uuid::fromString('1f2d3897-a226-4eec-bd2c-d0145ef25df9');

        $databaseValue = $uuid->getBytes();
        $entityValue = $uuid->toString();

        $type = new UuidType(UuidType::BYTES);

        $value = $type->convertToDatabaseValue($entityValue);
        $this->assertSame($databaseValue, $value);

        $value = $type->convertToPhpValue($databaseValue);
        $this->assertSame($entityValue, $value);
    }

    public function testIncorrectDatabaseType(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new UuidType('unknown');
    }

    public function testConvertToDatabaseValueIncorrectValue(): void
    {
        $type = new UuidType(UuidType::BYTES);

        $this->expectException(InvalidArgumentException::class);
        $type->convertToDatabaseValue(42);
    }

    public function testConvertToDatabaseValueIncorrectBytesValue(): void
    {
        $type = new UuidType(UuidType::BYTES);

        $this->expectException(InvalidArgumentException::class);
        $type->convertToDatabaseValue('incorrect');
    }

    public function testConvertToDatabaseValueWithIncorrectDatabaseType(): void
    {
        $property = (new ReflectionClass(UuidType::class))->getProperty('databaseType');
        $property->setAccessible(true);

        $type = new UuidType(UuidType::BYTES);
        $property->setValue($type, 'incorrect');

        $this->expectException(RuntimeException::class);
        $type->convertToDatabaseValue('1f2d3897-a226-4eec-bd2c-d0145ef25df9');
    }

    public function testConertToPhpValueIncorrectBytesValue(): void
    {
        $type = new UuidType(UuidType::BYTES);

        $this->expectException(InvalidArgumentException::class);
        $type->convertToPhpValue('incorrect');
    }

    public function testConertToPhpValueWithIncorrectDatabaseType(): void
    {
        $property = (new ReflectionClass(UuidType::class))->getProperty('databaseType');
        $property->setAccessible(true);

        $type = new UuidType(UuidType::BYTES);
        $property->setValue($type, 'incorrect');

        $this->expectException(RuntimeException::class);
        $type->convertToPhpValue(Uuid::fromString('1f2d3897-a226-4eec-bd2c-d0145ef25df9')->getBytes());
    }

    public function testConertToPhpValueWithIntegerValue(): void
    {
        $type = new UuidType(UuidType::BYTES);

        $this->expectException(InvalidArgumentException::class);
        $type->convertToPhpValue(42);
    }
}
