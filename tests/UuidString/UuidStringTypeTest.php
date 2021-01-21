<?php

declare(strict_types=1);

namespace Vjik\CycleTypecast\Tests\UuidString;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class UuidStringTypeTest extends TestCase
{
    public function testNull(): void
    {
        $type = new StubUuidStringType();
        $this->assertNull($type->convertToDatabaseValue(null));
        $this->assertNull($type->convertToPhpValue(null));
    }

    public function testConvertToDatabaseValueIncorrectValue(): void
    {
        $type = new StubUuidStringType();

        $this->expectException(InvalidArgumentException::class);
        $type->convertToDatabaseValue(42);
    }

    public function testConvertToDatabaseValueIncorrectStringValue(): void
    {
        $type = new StubUuidStringType();

        $this->expectException(InvalidArgumentException::class);
        $type->convertToDatabaseValue('incorrect');
    }
}
