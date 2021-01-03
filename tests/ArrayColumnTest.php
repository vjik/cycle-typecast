<?php

declare(strict_types=1);

namespace Vjik\CycleColumns\Tests;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Vjik\CycleColumns\ArrayColumn;

final class ArrayColumnTest extends TestCase
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
        ];
    }

    /**
     * @dataProvider dataBase
     *
     * @param string $databaseValue
     * @param array $entityValue
     */
    public function testBase(string $databaseValue, array $entityValue): void
    {
        $column = new ArrayColumn(',');

        $this->assertSame($databaseValue, $column->afterExtract($entityValue));
        $this->assertSame($entityValue, $column->beforeHydrate($databaseValue));
    }

    public function testAfterExtractIncorrectValue(): void
    {
        $column = new ArrayColumn(',');

        $this->expectException(InvalidArgumentException::class);
        $column->afterExtract(42);
    }
}
