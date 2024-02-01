<?php

declare(strict_types=1);

namespace Vjik\CycleTypecast\Tests\TestEnvironments\Php81;

use BackedEnum;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Vjik\CycleTypecast\IntegerEnumType;
use Vjik\CycleTypecast\Tests\TestEnvironments\Php81\Support\IntegerEnum;
use Vjik\CycleTypecast\Tests\TestEnvironments\Php81\Support\StringEnum;

final class IntegerEnumTypeTest extends TestCase
{
    public function dataBase(): array
    {
        return [
            [null, null],
            [1, IntegerEnum::A],
            [2, IntegerEnum::B],
        ];
    }

    /**
     * @dataProvider dataBase
     */
    public function testBase(?int $databaseValue, ?BackedEnum $entityValue): void
    {
        $type = new IntegerEnumType(IntegerEnum::class);

        $this->assertSame($databaseValue, $type->convertToDatabaseValue($entityValue));
        $this->assertSame($entityValue, $type->convertToPhpValue($databaseValue));
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
