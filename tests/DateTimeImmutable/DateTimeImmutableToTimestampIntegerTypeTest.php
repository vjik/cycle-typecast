<?php

declare(strict_types=1);

namespace Vjik\CycleTypecast\Tests\DateTimeImmutable;

use DateTimeImmutable;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use stdClass;
use Vjik\CycleTypecast\DateTimeImmutable\DateTimeImmutableToIntegerType;

final class DateTimeImmutableToTimestampIntegerTypeTest extends TestCase
{
    public function testBase(): void
    {
        $timestamp = 1609658768;

        $databaseValue = (string)$timestamp;
        $entityValue = (new DateTimeImmutable())->setTimestamp($timestamp);

        $type = new DateTimeImmutableToIntegerType();

        $value = $type->convertToDatabaseValue($entityValue);
        $this->assertSame($databaseValue, $value);

        $value = $type->convertToPhpValue($databaseValue);
        $this->assertInstanceOf(DateTimeImmutable::class, $value);
        $this->assertSame($timestamp, $value->getTimestamp());
    }

    public function testConertToPhpValueWithIntegerValue(): void
    {
        $timestamp = 1609658768;

        $type = new DateTimeImmutableToIntegerType();

        $value = $type->convertToPhpValue($timestamp);
        $this->assertInstanceOf(DateTimeImmutable::class, $value);
        $this->assertSame($timestamp, $value->getTimestamp());
    }

    public function testConertToPhpValueWithIncorrectValue(): void
    {
        $type = new DateTimeImmutableToIntegerType();

        $this->expectException(InvalidArgumentException::class);
        $type->convertToPhpValue(new stdClass());
    }
}
