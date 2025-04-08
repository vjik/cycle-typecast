<?php

declare(strict_types=1);

namespace Vjik\CycleTypecast\Tests;

use BackedEnum;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Vjik\CycleTypecast\IntegerEnumType;
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

        $this->assertSame($databaseValue, $type->convertToDatabaseValue($entityValue));
        $this->assertSame($entityValue, $type->convertToPhpValue($databaseValue));
    }

    public function testStringDatabaseValue(): void
    {
        $type = new IntegerEnumType(IntegerEnum::class);

        $this->assertSame(IntegerEnum::B, $type->convertToPhpValue('2'));
    }

    public function testConvertToDatabaseValueIncorrectValue(): void
    {
        $type = new IntegerEnumType(IntegerEnum::class);

        $this->expectException(InvalidArgumentException::class);
        $type->convertToDatabaseValue(StringEnum::A);
    }

    public function testConvertToPhpValueWithIntegerValue(): void
    {
        $type = new IntegerEnumType(IntegerEnum::class);

        $this->expectException(InvalidArgumentException::class);
        $type->convertToPhpValue(true);
    }
}
