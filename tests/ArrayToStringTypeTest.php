<?php

declare(strict_types=1);

namespace Vjik\CycleTypecast\Tests;

use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Vjik\CycleTypecast\ArrayToStringType;
use Vjik\CycleTypecast\Tests\Support\ContextFactory;

final class ArrayToStringTypeTest extends TestCase
{
    public static function dataBase(): array
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

    #[DataProvider('dataBase')]
    public function testBase(?string $databaseValue, ?array $entityValue): void
    {
        $type = new ArrayToStringType(',');

        $this->assertSame($databaseValue, $type->convertToDatabaseValue($entityValue, ContextFactory::uncastContext()));
        $this->assertSame($entityValue, $type->convertToPhpValue($databaseValue, ContextFactory::castContext()));
    }

    public function testConvertToDatabaseValueIncorrectValue(): void
    {
        $type = new ArrayToStringType(',');
        $context = ContextFactory::uncastContext();

        $this->expectException(InvalidArgumentException::class);
        $type->convertToDatabaseValue(42, $context);
    }

    public function testConvertToPhpValueWithIntegerValue(): void
    {
        $type = new ArrayToStringType(',');
        $context = ContextFactory::castContext();

        $this->expectException(InvalidArgumentException::class);
        $type->convertToPhpValue(42, $context);
    }
}
