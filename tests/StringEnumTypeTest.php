<?php

declare(strict_types=1);

namespace Vjik\CycleTypecast\Tests;

use BackedEnum;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Vjik\CycleTypecast\StringEnumType;
use Vjik\CycleTypecast\Tests\Support\IntegerEnum;
use Vjik\CycleTypecast\Tests\Support\StringEnum;

final class StringEnumTypeTest extends TestCase
{
    public static function dataBase(): array
    {
        return [
            [null, null],
            ['a', StringEnum::A],
            ['b', StringEnum::B],
        ];
    }

    #[DataProvider('dataBase')]
    public function testBase(?string $databaseValue, ?BackedEnum $entityValue): void
    {
        $type = new StringEnumType(StringEnum::class);

        $this->assertSame($databaseValue, $type->convertToDatabaseValue($entityValue));
        $this->assertSame($entityValue, $type->convertToPhpValue($databaseValue));
    }

    public function testConvertToDatabaseValueIncorrectValue(): void
    {
        $type = new StringEnumType(StringEnum::class);

        $this->expectException(InvalidArgumentException::class);
        $type->convertToDatabaseValue(IntegerEnum::A);
    }

    public function testConvertToPhpValueWithIntegerValue(): void
    {
        $type = new StringEnumType(StringEnum::class);

        $this->expectException(InvalidArgumentException::class);
        $type->convertToPhpValue(23);
    }
}
