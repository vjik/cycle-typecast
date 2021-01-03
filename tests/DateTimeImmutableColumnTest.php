<?php

declare(strict_types=1);

namespace Vjik\CycleColumns\Tests;

use DateTimeImmutable;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use RuntimeException;
use Vjik\CycleColumns\DateTimeImmutableColumn;

final class DateTimeImmutableColumnTest extends TestCase
{
    public function testBase(): void
    {
        $timestamp = 1609658768;

        $databaseValue = (string)$timestamp;
        $entityValue = (new DateTimeImmutable())->setTimestamp($timestamp);

        $column = new DateTimeImmutableColumn(DateTimeImmutableColumn::INTEGER);

        $value = $column->afterExtract($entityValue);
        $this->assertSame($databaseValue, $value);

        $value = $column->beforeHydrate($databaseValue);
        $this->assertInstanceOf(DateTimeImmutable::class, $value);
        $this->assertSame($timestamp, $value->getTimestamp());
    }

    public function testIncorrectColumnType(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new DateTimeImmutableColumn('unknown');
    }

    public function testAfterExtractIncorrectValue(): void
    {
        $column = new DateTimeImmutableColumn(DateTimeImmutableColumn::INTEGER);

        $this->expectException(InvalidArgumentException::class);
        $column->afterExtract(42);
    }

    public function testAfterExtractWithIncorrectColumnType(): void
    {
        $property = (new ReflectionClass(DateTimeImmutableColumn::class))->getProperty('columnType');
        $property->setAccessible(true);

        $column = new DateTimeImmutableColumn(DateTimeImmutableColumn::INTEGER);
        $property->setValue($column, 'incorrect');

        $this->expectException(RuntimeException::class);
        $column->afterExtract(new DateTimeImmutable());
    }

    public function testBeforeHydrateWithIncorrectColumnType(): void
    {
        $property = (new ReflectionClass(DateTimeImmutableColumn::class))->getProperty('columnType');
        $property->setAccessible(true);

        $column = new DateTimeImmutableColumn(DateTimeImmutableColumn::INTEGER);
        $property->setValue($column, 'incorrect');

        $this->expectException(RuntimeException::class);
        $column->beforeHydrate('1609658768');
    }
}
