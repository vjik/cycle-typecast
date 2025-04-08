<?php

declare(strict_types=1);

namespace Vjik\CycleTypecast\Tests;

use BackedEnum;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Vjik\CycleTypecast\IntegerEnumType;
use Vjik\CycleTypecast\Tests\Support\ContextFactory;
use Vjik\CycleTypecast\Tests\Support\IntegerEnum;
use Vjik\CycleTypecast\Tests\Support\StringEnum;

final class IntegerEnumTypeTest extends TestCase
{
    public static function dataBase(): array
    {
        return [
            [null, null],
            [1, IntegerEnum::A],
            [2, IntegerEnum::B],
        ];
    }

    #[DataProvider('dataBase')]
    public function testBase(?int $databaseValue, ?BackedEnum $entityValue): void
    {
        $type = new IntegerEnumType(IntegerEnum::class);

        $this->assertSame($databaseValue, $type->convertToDatabaseValue($entityValue, ContextFactory::uncastContext()));
        $this->assertSame($entityValue, $type->convertToPhpValue($databaseValue, ContextFactory::castContext()));
    }

    public function testStringDatabaseValue(): void
    {
        $type = new IntegerEnumType(IntegerEnum::class);

        $this->assertSame(IntegerEnum::B, $type->convertToPhpValue('2', ContextFactory::castContext()));
    }

    public function testConvertToDatabaseValueIncorrectValue(): void
    {
        $type = new IntegerEnumType(IntegerEnum::class);
        $context = ContextFactory::uncastContext();

        $this->expectException(InvalidArgumentException::class);
        $type->convertToDatabaseValue(StringEnum::A, $context);
    }

    public function testConvertToPhpValueWithIntegerValue(): void
    {
        $type = new IntegerEnumType(IntegerEnum::class);
        $context = ContextFactory::castContext();

        $this->expectException(InvalidArgumentException::class);
        $type->convertToPhpValue(true, $context);
    }
}
