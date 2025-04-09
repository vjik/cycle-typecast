<?php

declare(strict_types=1);

namespace Vjik\CycleTypecast\Tests\UuidString;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Vjik\CycleTypecast\Tests\Support\ContextFactory;
use Vjik\CycleTypecast\Tests\Support\StubUuidStringType;

final class UuidStringTypeTest extends TestCase
{
    public function testNull(): void
    {
        $type = new StubUuidStringType();
        $this->assertNull($type->convertToDatabaseValue(null, ContextFactory::uncastContext()));
        $this->assertNull($type->convertToPhpValue(null, ContextFactory::castContext()));
    }

    public function testConvertToDatabaseValueIncorrectValue(): void
    {
        $type = new StubUuidStringType();
        $context = ContextFactory::uncastContext();

        $this->expectException(InvalidArgumentException::class);
        $type->convertToDatabaseValue(42, $context);
    }

    public function testConvertToDatabaseValueIncorrectStringValue(): void
    {
        $type = new StubUuidStringType();
        $context = ContextFactory::uncastContext();

        $this->expectException(InvalidArgumentException::class);
        $type->convertToDatabaseValue('incorrect', $context);
    }
}
