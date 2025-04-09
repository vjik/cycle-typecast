<?php

declare(strict_types=1);

namespace Vjik\CycleTypecast\Tests\AttributeTypecastHandler;

use Cycle\ORM\SchemaInterface;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Vjik\CycleTypecast\AttributeTypecastHandler;
use Vjik\CycleTypecast\Tests\Support\EntityWithAttributes;

final class AttributeTypecastHandlerTest extends TestCase
{
    public function testBase(): void
    {
        $schema = $this->createMock(SchemaInterface::class);
        $schema
            ->method('define')
            ->with('role_user', SchemaInterface::ENTITY)
            ->willReturn(EntityWithAttributes::class);

        $typecastHandler = new AttributeTypecastHandler($schema, 'role_user');

        $uuid = Uuid::fromString('1f2d3897-a226-4eec-bd2c-d0145ef25df9');

        $data = $typecastHandler->uncast([
            'id' => '1f2d3897-a226-4eec-bd2c-d0145ef25df9',
            'names' => ['John', 'Doe'],
        ]);
        $this->assertSame(
            [
                'id' => $uuid->getBytes(),
                'names' => 'John,Doe',
            ],
            $data,
        );

        $data = $typecastHandler->cast([
            'id' => $uuid->getBytes(),
            'names' => 'John,Doe',
        ]);
        $this->assertSame(
            [
                'id' => '1f2d3897-a226-4eec-bd2c-d0145ef25df9',
                'names' => ['John', 'Doe'],
            ],
            $data,
        );

        $rules = $typecastHandler->setRules([
            'id' => 'string',
            'names' => 'array',
            'age' => 'int',
        ]);
        $this->assertSame(['age' => 'int'], $rules);
    }
}
