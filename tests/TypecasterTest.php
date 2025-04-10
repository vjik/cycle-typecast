<?php

declare(strict_types=1);

namespace Vjik\CycleTypecast\Tests;

use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Vjik\CycleTypecast\Tests\Support\StubType;
use Vjik\CycleTypecast\Typecaster;
use Vjik\CycleTypecast\UuidString\UuidStringToBytesType;

use function PHPUnit\Framework\assertSame;

final class TypecasterTest extends TestCase
{
    public function testPrepareAfterExtractBase(): void
    {
        $typecaster = new Typecaster([
            'id' => new UuidStringToBytesType(),
        ]);

        $uuid = Uuid::fromString('1f2d3897-a226-4eec-bd2c-d0145ef25df9');

        $data = $typecaster->prepareAfterExtract(['id' => $uuid->toString()]);
        $this->assertSame(['id' => $uuid->getBytes()], $data);
    }

    public function testPrepareAfterExtractNotExistsColumn(): void
    {
        $typecaster = new Typecaster([
            'id' => new UuidStringToBytesType(),
        ]);

        $data = $typecaster->prepareAfterExtract(['name' => 'Mike']);
        $this->assertSame(['name' => 'Mike'], $data);
    }

    public function testPrepareAfterExtractNull(): void
    {
        $typecaster = new Typecaster([
            'id' => new UuidStringToBytesType(),
        ]);

        $data = $typecaster->prepareAfterExtract(['id' => null]);
        $this->assertSame(['id' => null], $data);
    }

    public function testPrepareBeforeHydrateBase(): void
    {
        $typecaster = new Typecaster([
            'id' => new UuidStringToBytesType(),
        ]);

        $uuid = Uuid::fromString('1f2d3897-a226-4eec-bd2c-d0145ef25df9');

        $data = $typecaster->prepareBeforeHydrate(['id' => $uuid->getBytes()]);
        $this->assertSame(['id' => $uuid->toString()], $data);
    }

    public function testPrepareBeforeHydrateNotExistsColumn(): void
    {
        $typecaster = new Typecaster([
            'id' => new UuidStringToBytesType(),
        ]);

        $data = $typecaster->prepareBeforeHydrate(['name' => 'Mike']);
        $this->assertSame(['name' => 'Mike'], $data);
    }

    public function testPrepareBeforeHydrateNull(): void
    {
        $typecaster = new Typecaster([
            'id' => new UuidStringToBytesType(),
        ]);

        $data = $typecaster->prepareBeforeHydrate(['id' => null]);
        $this->assertSame(['id' => null], $data);
    }

    public function testUncastContext(): void
    {
        $type = new StubType();

        $typecaster = new Typecaster(['id' => $type]);
        $typecaster->prepareAfterExtract([
            'id' => '1f2d3897-a226-4eec-bd2c-d0145ef25df9',
            'city' => 'Voronezh',
        ]);

        assertSame('1f2d3897-a226-4eec-bd2c-d0145ef25df9', $type->getToDatabaseValue());
        assertSame('id', $type->getUncastContext()?->property);
        assertSame(
            [
                'id' => '1f2d3897-a226-4eec-bd2c-d0145ef25df9',
                'city' => 'Voronezh',
            ],
            $type->getUncastContext()?->data,
        );
    }

    public function testCastContext(): void
    {
        $type = new StubType();

        $typecaster = new Typecaster(['id' => $type]);
        $typecaster->prepareBeforeHydrate([
            'id' => '1f2d3897-a226-4eec-bd2c-d0145ef25df9',
            'city' => 'Voronezh',
        ]);

        assertSame('1f2d3897-a226-4eec-bd2c-d0145ef25df9', $type->getToPhpValue());
        assertSame('id', $type->getCastContext()?->property);
        assertSame(
            [
                'id' => '1f2d3897-a226-4eec-bd2c-d0145ef25df9',
                'city' => 'Voronezh',
            ],
            $type->getCastContext()?->data,
        );
    }
}
