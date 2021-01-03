<?php

declare(strict_types=1);

namespace Vjik\CycleTypecast;

final class Typecaster
{
    /**
     * @var array<string, TypeInterface>
     */
    private array $config = [];

    /**
     * @param array<string, TypeInterface> $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function afterExtract(array &$data): void
    {
        foreach ($this->config as $column => $type) {
            if (array_key_exists($column, $data)) {
                /** @var mixed */
                $data[$column] = $type->convertToDatabaseValue($data[$column]);
            }
        }
    }

    public function beforeHydrate(array &$data): void
    {
        foreach ($this->config as $column => $type) {
            if (array_key_exists($column, $data)) {
                /** @var mixed */
                $data[$column] = $type->convertToPhpValue($data[$column]);
            }
        }
    }
}
