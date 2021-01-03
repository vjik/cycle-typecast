<?php

declare(strict_types=1);

namespace Vjik\CycleTypecast\Tests;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Vjik\CycleTypecast\ArrayType;
use Vjik\CycleTypecast\Typecaster;
use Vjik\CycleTypecast\UuidType;

final class TypecasterTest extends TestCase
{
    public function testAfterExtractBase(): void
    {
        $typecaster = new Typecaster([
            'id' => new UuidType(UuidType::BYTES),
        ]);

        $uuid = Uuid::fromString('1f2d3897-a226-4eec-bd2c-d0145ef25df9');

        $data = ['id' => $uuid->toString()];
        $typecaster->afterExtract($data);
        $this->assertSame(['id' => $uuid->getBytes()], $data);
    }

    public function testAfterExtractNotExistsColumn(): void
    {
        $typecaster = new Typecaster([
            'id' => new UuidType(UuidType::BYTES),
        ]);

        $data = ['name' => 'Mike'];
        $typecaster->afterExtract($data);
        $this->assertSame(['name' => 'Mike'], $data);
    }

    public function testAfterExtractNull(): void
    {
        $typecaster = new Typecaster([
            'id' => new UuidType(UuidType::BYTES),
        ]);

        $data = ['id' => null];
        $typecaster->afterExtract($data);
        $this->assertSame(['id' => null], $data);
    }

    public function testBeforeHydrateBase(): void
    {
        $typecaster = new Typecaster([
            'id' => new UuidType(UuidType::BYTES),
        ]);

        $uuid = Uuid::fromString('1f2d3897-a226-4eec-bd2c-d0145ef25df9');

        $data = ['id' => $uuid->getBytes()];
        $typecaster->beforeHydrate($data);
        $this->assertSame(['id' => $uuid->toString()], $data);
    }

    public function testBeforeHydrateNotExistsColumn(): void
    {
        $typecaster = new Typecaster([
            'id' => new UuidType(UuidType::BYTES),
        ]);

        $data = ['name' => 'Mike'];
        $typecaster->beforeHydrate($data);
        $this->assertSame(['name' => 'Mike'], $data);
    }

    public function testBeforeHydrateNull(): void
    {
        $typecaster = new Typecaster([
            'id' => new UuidType(UuidType::BYTES),
        ]);

        $data = ['id' => null];
        $typecaster->beforeHydrate($data);
        $this->assertSame(['id' => null], $data);
    }
}
