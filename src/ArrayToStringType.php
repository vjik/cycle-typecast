<?php

declare(strict_types=1);

namespace Vjik\CycleTypecast;

use Attribute;
use InvalidArgumentException;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class ArrayToStringType implements TypeInterface
{
    /**
     * @psalm-var non-empty-string
     */
    private string $delimiter;

    /**
     * @psalm-param non-empty-string $delimiter
     */
    public function __construct(string $delimiter)
    {
        $this->delimiter = $delimiter;
    }

    public function convertToDatabaseValue(mixed $value, UncastContext $context): mixed
    {
        if ($value === null) {
            return null;
        }

        if (!is_array($value)) {
            throw new InvalidArgumentException('Incorrect value.');
        }

        /** @psalm-suppress MixedArgumentTypeCoercion */
        return implode($this->delimiter, $value);
    }

    public function convertToPhpValue(mixed $value, CastContext $context): mixed
    {
        if ($value === null) {
            return null;
        }

        if (!is_string($value)) {
            throw new InvalidArgumentException('Incorrect value.');
        }

        if ($value === '') {
            return [];
        }

        return explode($this->delimiter, $value);
    }
}
