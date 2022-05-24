<?php

declare(strict_types=1);

namespace Vjik\CycleTypecast\Tests\DateTimeImmutable;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Vjik\CycleTypecast\Tests\Support\StubDateTimeImmutableType;

final class DateTimeImmutableTypeTest extends TestCase
{
    public function testNull(): void
    {
        $type = new StubDateTimeImmutableType();
        $this->assertNull($type->convertToDatabaseValue(null));
        $this->assertNull($type->convertToPhpValue(null));
    }

    public function testConvertToDatabaseValueIncorrectValue(): void
    {
        $type = new StubDateTimeImmutableType();

        $this->expectException(InvalidArgumentException::class);
        $type->convertToDatabaseValue(42);
    }
}
