<?php

declare(strict_types=1);

namespace Vjik\CycleColumns;

use InvalidArgumentException;

final class ColumnsManager
{
    /**
     * @var array<string, ColumnInterface>
     */
    private array $config = [];

    /**
     * @param array<string, ColumnInterface> $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function afterExtract(array &$data): void
    {
        foreach ($this->config as $name => $column) {
            if (isset($data[$name])) {
                $data[$name] = $column->afterExtract($data[$name]);
            }
        }
    }

    public function beforeHydrate(array &$data): void
    {
        foreach ($this->config as $name => $column) {
            if (isset($data[$name])) {
                if (!is_string($data[$name])) {
                    throw new InvalidArgumentException('Incorrect value.');
                }
                /** @var mixed */
                $data[$name] = $column->beforeHydrate($data[$name]);
            }
        }
    }
}
