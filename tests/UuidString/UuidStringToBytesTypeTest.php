<?php

declare(strict_types=1);

namespace Vjik\CycleTypecast\Tests\UuidString;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Vjik\CycleTypecast\Tests\Support\ContextFactory;
use Vjik\CycleTypecast\UuidString\UuidStringToBytesType;

final class UuidStringToBytesTypeTest extends TestCase
{
    public function testBase(): void
    {
        $uuid = Uuid::fromString('1f2d3897-a226-4eec-bd2c-d0145ef25df9');

        $databaseValue = $uuid->getBytes();
        $entityValue = $uuid->toString();

        $type = new UuidStringToBytesType();

        $value = $type->convertToDatabaseValue($entityValue, ContextFactory::uncastContext());
        $this->assertSame($databaseValue, $value);

        $value = $type->convertToPhpValue($databaseValue, ContextFactory::castContext());
        $this->assertSame($entityValue, $value);
    }

    public function testConertToPhpValueIncorrectBytesValue(): void
    {
        $type = new UuidStringToBytesType();
        $context = ContextFactory::castContext();

        $this->expectException(InvalidArgumentException::class);
        $type->convertToPhpValue('incorrect', $context);
    }


    public function testConvertToPhpValueWithIntegerValue(): void
    {
        $type = new UuidStringToBytesType();
        $context = ContextFactory::castContext();

        $this->expectException(InvalidArgumentException::class);
        $type->convertToPhpValue(42, $context);
    }
}
