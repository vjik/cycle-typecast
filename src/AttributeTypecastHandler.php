<?php

declare(strict_types=1);

namespace Vjik\CycleTypecast;

use Cycle\ORM\Parser\CastableInterface;
use Cycle\ORM\Parser\UncastableInterface;
use Cycle\ORM\SchemaInterface;
use ReflectionAttribute;
use ReflectionClass;

final class AttributeTypecastHandler implements CastableInterface, UncastableInterface
{
    /**
     * @var TypeInterface[]
     * @psalm-var array<string, TypeInterface>
     */
    private array $types = [];

    public function __construct(SchemaInterface $schema, string $role)
    {
        /** @psalm-var class-string $entityClass */
        $entityClass = $schema->define($role, SchemaInterface::ENTITY);
        $reflection = new ReflectionClass($entityClass);
        foreach ($reflection->getProperties() as $property) {
            $attributes = $property->getAttributes(TypeInterface::class, ReflectionAttribute::IS_INSTANCEOF);
            if (empty($attributes)) {
                continue;
            }
            $this->types[$property->getName()] = $attributes[0]->newInstance();
        }
    }

    public function setRules(array $rules): array
    {
        foreach ($rules as $key => $_rule) {
            if (isset($this->types[$key])) {
                unset($rules[$key]);
            }
        }
        return $rules;
    }

    public function cast(array $data): array
    {
        /** @psalm-var array<non-empty-string, mixed> $data */
        foreach ($data as $key => $value) {
            if (isset($this->types[$key])) {
                $data[$key] = $this->types[$key]->convertToPhpValue($value);
            }
        }
        return $data;
    }

    public function uncast(array $data): array
    {
        /** @psalm-var array<non-empty-string, mixed> $data */
        foreach ($data as $key => $value) {
            if (isset($this->types[$key])) {
                $data[$key] = $this->types[$key]->convertToDatabaseValue($value);
            }
        }
        return $data;
    }
}
