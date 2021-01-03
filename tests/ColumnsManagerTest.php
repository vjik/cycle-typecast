<?php

declare(strict_types=1);

namespace Vjik\CycleColumns\Tests;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Vjik\CycleColumns\ArrayColumn;
use Vjik\CycleColumns\ColumnsManager;
use Vjik\CycleColumns\UuidColumn;

final class ColumnsManagerTest extends TestCase
{
    public function testAfterExtractBase(): void
    {
        $columnsManager = new ColumnsManager([
            'id' => new UuidColumn(UuidColumn::BYTES),
        ]);

        $uuid = Uuid::fromString('1f2d3897-a226-4eec-bd2c-d0145ef25df9');

        $data = ['id' => $uuid->toString()];
        $columnsManager->afterExtract($data);
        $this->assertSame(['id' => $uuid->getBytes()], $data);
    }

    public function testAfterExtractNotExistsColumn(): void
    {
        $columnsManager = new ColumnsManager([
            'id' => new UuidColumn(UuidColumn::BYTES),
        ]);

        $data = ['name' => 'Mike'];
        $columnsManager->afterExtract($data);
        $this->assertSame(['name' => 'Mike'], $data);
    }

    public function testAfterExtractNull(): void
    {
        $columnsManager = new ColumnsManager([
            'id' => new UuidColumn(UuidColumn::BYTES),
        ]);

        $data = ['id' => null];
        $columnsManager->afterExtract($data);
        $this->assertSame(['id' => null], $data);
    }

    public function testBeforeHydrateBase(): void
    {
        $columnsManager = new ColumnsManager([
            'id' => new UuidColumn(UuidColumn::BYTES),
        ]);

        $uuid = Uuid::fromString('1f2d3897-a226-4eec-bd2c-d0145ef25df9');

        $data = ['id' => $uuid->getBytes()];
        $columnsManager->beforeHydrate($data);
        $this->assertSame(['id' => $uuid->toString()], $data);
    }

    public function testBeforeHydrateNotExistsColumn(): void
    {
        $columnsManager = new ColumnsManager([
            'id' => new UuidColumn(UuidColumn::BYTES),
        ]);

        $data = ['name' => 'Mike'];
        $columnsManager->beforeHydrate($data);
        $this->assertSame(['name' => 'Mike'], $data);
    }

    public function testBeforeHydrateNull(): void
    {
        $columnsManager = new ColumnsManager([
            'id' => new UuidColumn(UuidColumn::BYTES),
        ]);

        $data = ['id' => null];
        $columnsManager->beforeHydrate($data);
        $this->assertSame(['id' => null], $data);
    }

    public function testBeforeHydrateWithIncorrectValue(): void
    {
        $columnsManager = new ColumnsManager([
            'id' => new ArrayColumn(','),
        ]);

        $data = ['id' => 42];

        $this->expectException(InvalidArgumentException::class);
        $columnsManager->beforeHydrate($data);
    }
}
