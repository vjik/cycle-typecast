<?php

declare(strict_types=1);

namespace Vjik\CycleColumns\Tests;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Reflection;
use ReflectionClass;
use ReflectionObject;
use RuntimeException;
use Vjik\CycleColumns\UuidColumn;

final class UuidColumnTest extends TestCase
{
    public function testBase(): void
    {
        $uuid = Uuid::fromString('1f2d3897-a226-4eec-bd2c-d0145ef25df9');

        $databaseValue = $uuid->getBytes();
        $entityValue = $uuid->toString();

        $column = new UuidColumn(UuidColumn::BYTES);

        $value = $column->afterExtract($entityValue);
        $this->assertSame($databaseValue, $value);

        $value = $column->beforeHydrate($databaseValue);
        $this->assertSame($entityValue, $value);
    }

    public function testIncorrectColumnType(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new UuidColumn('unknown');
    }

    public function testAfterExtractIncorrectValue(): void
    {
        $column = new UuidColumn(UuidColumn::BYTES);

        $this->expectException(InvalidArgumentException::class);
        $column->afterExtract(42);
    }

    public function testAfterExtractIncorrectBytesValue(): void
    {
        $column = new UuidColumn(UuidColumn::BYTES);

        $this->expectException(InvalidArgumentException::class);
        $column->afterExtract('incorrect');
    }

    public function testAfterExtractWithIncorrectColumnType(): void
    {
        $property = (new ReflectionClass(UuidColumn::class))->getProperty('columnType');
        $property->setAccessible(true);

        $column = new UuidColumn(UuidColumn::BYTES);
        $property->setValue($column, 'incorrect');

        $this->expectException(RuntimeException::class);
        $column->afterExtract('1f2d3897-a226-4eec-bd2c-d0145ef25df9');
    }

    public function testBeforeHydrateIncorrectBytesValue(): void
    {
        $column = new UuidColumn(UuidColumn::BYTES);

        $this->expectException(InvalidArgumentException::class);
        $column->beforeHydrate('incorrect');
    }

    public function testBeforeHydrateWithIncorrectColumnType(): void
    {
        $property = (new ReflectionClass(UuidColumn::class))->getProperty('columnType');
        $property->setAccessible(true);

        $column = new UuidColumn(UuidColumn::BYTES);
        $property->setValue($column, 'incorrect');

        $this->expectException(RuntimeException::class);
        $column->beforeHydrate(Uuid::fromString('1f2d3897-a226-4eec-bd2c-d0145ef25df9')->getBytes());
    }
}
