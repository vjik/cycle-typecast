<?php

declare(strict_types=1);

namespace Vjik\CycleTypecast\Tests\UuidString;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Vjik\CycleTypecast\UuidString\UuidStringToBytesType;

final class UuidStringToBytesTypeTest extends TestCase
{
    public function testBase(): void
    {
        $uuid = Uuid::fromString('1f2d3897-a226-4eec-bd2c-d0145ef25df9');

        $databaseValue = $uuid->getBytes();
        $entityValue = $uuid->toString();

        $type = new UuidStringToBytesType();

        $value = $type->convertToDatabaseValue($entityValue);
        $this->assertSame($databaseValue, $value);

        $value = $type->convertToPhpValue($databaseValue);
        $this->assertSame($entityValue, $value);
    }

    public function testConertToPhpValueIncorrectBytesValue(): void
    {
        $type = new UuidStringToBytesType();

        $this->expectException(InvalidArgumentException::class);
        $type->convertToPhpValue('incorrect');
    }


    public function testConertToPhpValueWithIntegerValue(): void
    {
        $type = new UuidStringToBytesType();

        $this->expectException(InvalidArgumentException::class);
        $type->convertToPhpValue(42);
    }
}
