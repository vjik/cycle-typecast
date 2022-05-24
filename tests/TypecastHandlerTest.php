<?php

declare(strict_types=1);

namespace Vjik\CycleTypecast\Tests;

use PHPUnit\Framework\TestCase;
use Vjik\CycleTypecast\Tests\Support\StubTypecastHandler;

final class TypecastHandlerTest extends TestCase
{
    public function testSetRules(): void
    {
        $typecastHandler = new StubTypecastHandler();

        $result = $typecastHandler->setRules([
            'id' => 'int',
            'letters' => 'array',
            'name' => 'string',
        ]);

        $this->assertSame(
            [
                'id' => 'int',
                'name' => 'string',
            ],
            $result
        );
    }

    public function testCast(): void
    {
        $typecastHandler = new StubTypecastHandler();

        $result = $typecastHandler->cast([
            'id' => 42,
            'letters' => 'A,B,C',
        ]);

        $this->assertSame(
            [
                'id' => 42,
                'letters' => ['A', 'B', 'C'],
            ],
            $result
        );
    }

    public function testUncast(): void
    {
        $typecastHandler = new StubTypecastHandler();

        $result = $typecastHandler->uncast([
            'id' => 42,
            'letters' => ['A', 'B', 'C'],
        ]);

        $this->assertSame(
            [
                'id' => 42,
                'letters' => 'A,B,C',
            ],
            $result
        );
    }
}
