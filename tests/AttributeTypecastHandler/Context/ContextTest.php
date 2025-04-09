<?php

declare(strict_types=1);

namespace Vjik\CycleTypecast\Tests\AttributeTypecastHandler\Context;

use Cycle\ORM\SchemaInterface;
use PHPUnit\Framework\TestCase;
use Vjik\CycleTypecast\AttributeTypecastHandler;

use Vjik\CycleTypecast\CastContext;
use Vjik\CycleTypecast\UncastContext;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertSame;

final class ContextTest extends TestCase
{
    public function testBase(): void
    {
        $schema = $this->createMock(SchemaInterface::class);
        $schema
            ->method('define')
            ->with('role_user', SchemaInterface::ENTITY)
            ->willReturn(Entity::class);

        $typecastHandler = new AttributeTypecastHandler($schema, 'role_user');

        $context = $typecastHandler->uncast([
            'id' => '1f2d3897-a226-4eec-bd2c-d0145ef25df9',
            'name' => 'John',
        ])['id'];
        assertInstanceOf(UncastContext::class, $context);
        assertSame('id', $context->property);
        assertSame(
            [
                'id' => '1f2d3897-a226-4eec-bd2c-d0145ef25df9',
                'name' => 'John',
            ],
            $context->data
        );

        $context = $typecastHandler->cast([
            'id' => '2f2d3897-a226-4eec-bd2c-d0145ef25df9',
            'name' => 'Doe',
        ])['id'];
        assertInstanceOf(CastContext::class, $context);
        assertSame('id', $context->property);
        assertSame(
            [
                'id' => '2f2d3897-a226-4eec-bd2c-d0145ef25df9',
                'name' => 'Doe',
            ],
            $context->data
        );
    }
}
