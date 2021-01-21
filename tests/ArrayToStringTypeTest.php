<?php

declare(strict_types=1);

namespace Vjik\CycleTypecast\Tests;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Vjik\CycleTypecast\ArrayToStringType;

final class ArrayToStringTypeTest extends TestCase
{
    public function dataBase(): array
    {
        return [
            'empty' => [
                '',
                [],
            ],
            'nonEmpty' => [
                'A,B,C',
                ['A', 'B', 'C'],
            ],
            'null' => [
                null,
                null,
            ],
        ];
    }

    /**
     * @dataProvider dataBase
     *
     * @param string|null $databaseValue
     * @param array|null $entityValue
     */
    public function testBase(?string $databaseValue, ?array $entityValue): void
    {
        $type = new ArrayToStringType(',');

        $this->assertSame($databaseValue, $type->convertToDatabaseValue($entityValue));
        $this->assertSame($entityValue, $type->convertToPhpValue($databaseValue));
    }

    public function testConvertToDatabaseValueIncorrectValue(): void
    {
        $type = new ArrayToStringType(',');

        $this->expectException(InvalidArgumentException::class);
        $type->convertToDatabaseValue(42);
    }

    public function testConertToPhpValueWithIntegerValue(): void
    {
        $type = new ArrayToStringType(',');

        $this->expectException(InvalidArgumentException::class);
        $type->convertToPhpValue(42);
    }
}
