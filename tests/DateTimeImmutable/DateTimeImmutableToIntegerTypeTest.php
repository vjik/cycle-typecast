<?php

declare(strict_types=1);

namespace Vjik\CycleTypecast\Tests\DateTimeImmutable;

use DateTimeImmutable;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use stdClass;
use Vjik\CycleTypecast\DateTimeImmutable\DateTimeImmutableToIntegerType;
use Vjik\CycleTypecast\Tests\Support\ContextFactory;

final class DateTimeImmutableToIntegerTypeTest extends TestCase
{
    public function testBase(): void
    {
        $timestamp = 1609658768;

        $databaseValue = (string)$timestamp;
        $entityValue = (new DateTimeImmutable())->setTimestamp($timestamp);

        $type = new DateTimeImmutableToIntegerType();

        $value = $type->convertToDatabaseValue($entityValue, ContextFactory::uncastContext());
        $this->assertSame($databaseValue, $value);

        $value = $type->convertToPhpValue($databaseValue, ContextFactory::castContext());
        $this->assertInstanceOf(DateTimeImmutable::class, $value);
        $this->assertSame($timestamp, $value->getTimestamp());
    }

    public function testConvertToPhpValueWithIntegerValue(): void
    {
        $timestamp = 1609658768;

        $type = new DateTimeImmutableToIntegerType();

        $value = $type->convertToPhpValue($timestamp, ContextFactory::castContext());
        $this->assertInstanceOf(DateTimeImmutable::class, $value);
        $this->assertSame($timestamp, $value->getTimestamp());
    }

    public function testConvertToPhpValueWithIncorrectValue(): void
    {
        $type = new DateTimeImmutableToIntegerType();
        $context = ContextFactory::castContext();

        $this->expectException(InvalidArgumentException::class);
        $type->convertToPhpValue(new stdClass(), $context);
    }
}
