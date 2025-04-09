<?php

declare(strict_types=1);

namespace Vjik\CycleTypecast\Tests\AttributeTypecastHandler\Context;

final class Entity
{
    #[ContextType]
    public string $id = '';

    public string $name = '';
}
